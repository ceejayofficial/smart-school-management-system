document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const reset = urlParams.get("reset");

  if (reset === "success") {
    Swal.fire({
      icon: "success",
      title: "Password Reset Successful",
      text: "You can now log in with your new password.",
    }).then(() => {
      urlParams.delete("reset");
      const newUrl =
        window.location.origin +
        window.location.pathname +
        (urlParams.toString() ? "?" + urlParams.toString() : "");
      window.history.replaceState({}, document.title, newUrl);
    });
  }
});
