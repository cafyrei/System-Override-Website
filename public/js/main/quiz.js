// Quiz front end. This file only DISPLAYS things: the server picks the
// questions, holds the clock, grades answers and ranks the leaderboard.
// Tampering with anything here can't change a score.

(() => {
  const cfg = window.QUIZ;
  const $ = (id) => document.getElementById(id);

  const screens = {
    start: $("screen-start"),
    play: $("screen-play"),
    result: $("screen-result"),
  };
  const choiceButtons = [...document.querySelectorAll(".quiz-choice")];
  const csrf =
    document.querySelector('meta[name="X-CSRF-TOKEN"]')?.content ?? "";

  const state = {
    token: null,
    total: 0,
    seconds: 15,
    locked: true,
    frame: 0,
    me: null,
  };

  const sleep = (ms) => new Promise((resolve) => setTimeout(resolve, ms));
  const fmt = (ms) => (ms / 1000).toFixed(2) + "s";

  function show(name) {
    for (const [key, el] of Object.entries(screens)) el.hidden = key !== name;
  }

  async function request(url, data) {
    const init = {
      headers: { Accept: "application/json", "X-Requested-With": "XMLHttpRequest" },
    };

    if (data) {
      init.method = "POST";
      init.headers["X-CSRF-TOKEN"] = csrf;
      init.body = new URLSearchParams(data);
    }

    const res = await fetch(url, init);
    let json = {};
    try {
      json = await res.json();
    } catch {
      // non-JSON body: fall through to the status check
    }

    if (!res.ok || !json.success) {
      throw new Error(json.message || `Request failed (${res.status})`);
    }
    return json;
  }

  // ---------------------------------------------------------------- timer
  // Cosmetic. The server decides whether an answer was in time.
  function startTimer() {
    const bar = $("timer-bar");
    const text = $("timer-text");
    const wrap = bar.parentElement;
    const startedAt = performance.now();
    const limit = state.seconds * 1000;

    cancelAnimationFrame(state.frame);
    wrap.classList.remove("is-low");

    const tick = (now) => {
      const left = Math.max(0, limit - (now - startedAt));
      bar.style.width = (left / limit) * 100 + "%";
      text.textContent = (left / 1000).toFixed(1) + "s";
      wrap.classList.toggle("is-low", left < 5000);

      if (left <= 0) {
        submit(0); // 0 = no answer; the server confirms it as a timeout
        return;
      }
      state.frame = requestAnimationFrame(tick);
    };

    state.frame = requestAnimationFrame(tick);
  }

  // ------------------------------------------------------------- rendering
  function showQuestion(q) {
    $("q-number").textContent = `${q.number} / ${state.total}`;
    $("progress-bar").style.width = ((q.number - 1) / state.total) * 100 + "%";
    $("q-text").textContent = q.text;
    $("feedback").textContent = "";
    $("feedback").className = "quiz-feedback";

    choiceButtons.forEach((btn, i) => {
      btn.querySelector(".quiz-choice-text").textContent = q.choices[i];
      btn.className = "quiz-choice";
      btn.disabled = false;
    });

    state.locked = false;
    startTimer();
  }

  function reveal(result, chosen) {
    const feedback = $("feedback");

    choiceButtons.forEach((btn, i) => {
      const n = i + 1;
      btn.disabled = true;
      if (n === result.correctChoice) btn.classList.add("is-correct");
      else if (n === chosen) btn.classList.add("is-wrong");
      else btn.classList.add("is-dim");
    });

    if (result.correct) {
      feedback.textContent = `Correct // ${fmt(result.elapsedMs)}`;
      feedback.className = "quiz-feedback is-correct";
    } else if (result.timedOut || chosen === 0) {
      feedback.textContent = "Time out // full penalty";
      feedback.className = "quiz-feedback is-wrong";
    } else {
      feedback.textContent = "Wrong // full penalty";
      feedback.className = "quiz-feedback is-wrong";
    }
  }

  function finish(result) {
    state.me = { name: result.name, rank: result.rank };

    $("result-name").textContent = result.name;
    $("result-score").textContent = `${result.score} / ${result.total}`;
    $("result-time").textContent = fmt(result.totalTimeMs);
    $("result-rank").textContent = `#${result.rank}`;

    show("result");
    refreshBoard();
  }

  async function refreshBoard() {
    try {
      const { entries } = await request(cfg.leaderboardUrl);
      const body = $("board-body");
      body.replaceChildren();

      if (entries.length === 0) {
        const tr = body.insertRow();
        tr.className = "quiz-board-empty";
        const td = tr.insertCell();
        td.colSpan = 4;
        td.textContent = "No finished rounds yet. Be the first.";
        return;
      }

      for (const e of entries) {
        const tr = body.insertRow();
        // textContent only: callsigns are user input and must never be parsed as HTML
        tr.insertCell().textContent = e.rank;
        tr.insertCell().textContent = e.name;
        tr.insertCell().textContent = `${e.score}/${e.total}`;
        tr.insertCell().textContent = fmt(e.timeMs);

        if (state.me && e.rank === state.me.rank && e.name === state.me.name) {
          tr.classList.add("is-me");
        }
      }
    } catch {
      // The board is a nicety; a failed refresh shouldn't interrupt the player.
    }
  }

  // ------------------------------------------------------------------ flow
  async function submit(choice) {
    if (state.locked) return;
    state.locked = true;
    cancelAnimationFrame(state.frame);
    choiceButtons.forEach((btn) => (btn.disabled = true));

    try {
      const result = await request(cfg.answerUrl, { token: state.token, choice });

      reveal(result, choice);
      $("score").textContent = result.score;
      $("progress-bar").style.width =
        ((result.finished ? state.total : choiceProgress(result)) / state.total) * 100 + "%";

      await sleep(cfg.feedbackMs);

      if (result.finished) {
        finish(result.result);
        return;
      }

      const next = await request(cfg.nextUrl, { token: state.token });
      showQuestion(next.question);
    } catch (err) {
      abort(err.message);
    }
  }

  // questions answered so far = the number currently shown (1-based)
  function choiceProgress() {
    const shown = parseInt($("q-number").textContent, 10);
    return Number.isFinite(shown) ? shown : 0;
  }

  function abort(message) {
    cancelAnimationFrame(state.frame);
    state.locked = true;
    state.token = null;
    show("start");
    const err = $("start-error");
    err.textContent = message;
    err.hidden = false;
    $("start-btn").disabled = false;
  }

  $("start-form").addEventListener("submit", async (event) => {
    event.preventDefault();

    const name = $("player-name").value.trim();
    const err = $("start-error");
    const btn = $("start-btn");

    err.hidden = true;
    btn.disabled = true;

    try {
      const round = await request(cfg.startUrl, { player_name: name });

      state.token = round.token;
      state.total = round.total;
      state.seconds = round.seconds;
      state.me = null;

      $("score").textContent = "0";
      show("play");
      showQuestion(round.question);
    } catch (e) {
      err.textContent = e.message;
      err.hidden = false;
    } finally {
      btn.disabled = false;
    }
  });

  choiceButtons.forEach((btn) =>
    btn.addEventListener("click", () => submit(Number(btn.dataset.choice))),
  );

  // Keyboard: 1-4 or A-D
  document.addEventListener("keydown", (event) => {
    if (screens.play.hidden || state.locked || event.ctrlKey || event.metaKey || event.altKey) {
      return;
    }
    const index = "1234".indexOf(event.key) !== -1
      ? "1234".indexOf(event.key)
      : "abcd".indexOf(event.key.toLowerCase());

    if (index >= 0 && event.key.length === 1) submit(index + 1);
  });

  $("again-btn").addEventListener("click", () => {
    state.me = null;
    $("start-error").hidden = true;
    show("start");
    $("player-name").focus();
  });
})();