// Shared helper for admin mutations (delete, mark reviewed).
//
// Every state-changing request is a POST carrying the CSRF token that the
// dashboard renders into <meta name="X-CSRF-TOKEN"> (see csrf_meta()).
// Resolves with the parsed JSON on success; rejects with a readable Error
// otherwise, including when the session has expired (401).

window.adminPost = async function adminPost(url) {
  const token =
    document.querySelector('meta[name="X-CSRF-TOKEN"]')?.content ?? "";

  const res = await fetch(url, {
    method: "POST",
    headers: {
      "X-CSRF-TOKEN": token,
      "X-Requested-With": "XMLHttpRequest",
      Accept: "application/json",
    },
  });

  let json = {};
  try {
    json = await res.json();
  } catch {
    // non-JSON body (e.g. a redirect page); fall through to the status check
  }

  if (res.status === 401) {
    throw new Error("Your session expired. Reload the page and log in again.");
  }

  if (!res.ok || !json.success) {
    throw new Error(json.message || `Request failed (${res.status})`);
  }

  return json;
};
