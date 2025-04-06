document.addEventListener("DOMContentLoaded", function () {
    function checkNotifications() {
        fetch("notifications.php")
            .then(response => response.text())
            .then(data => {
                if (data) {
                    alert(data);
                }
            });
    }

    setInterval(checkNotifications, 60000); // Check every minute
});
