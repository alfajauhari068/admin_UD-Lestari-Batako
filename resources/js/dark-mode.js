/*
 * Simple dark-mode toggle script.
 * - Toggles `data-theme` on <body>
 * - Posts preference to `profile.toggle-dark-mode` endpoint if available
 */
document.addEventListener("DOMContentLoaded", function () {
    const toggleButtons = document.querySelectorAll("#sidebar-dark-toggle");
    const body = document.body;
    function toggleAndPersist() {
        const isDark = body.getAttribute("data-theme") === "dark";
        const newTheme = isDark ? "light" : "dark";
        body.setAttribute("data-theme", newTheme);

        // Try to persist via fetch to server (CSRF token required)
        try {
            const token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            fetch("/profile/toggle-dark-mode", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                },
                body: JSON.stringify({ dark_mode: newTheme === "dark" }),
            }).catch(() => {});
        } catch (e) {
            /* ignore if endpoint not present */
        }
    }

    toggleButtons.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            toggleAndPersist();
        });
    });
});
