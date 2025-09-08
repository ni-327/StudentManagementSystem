<!-- student/include/topbar.php -->
<style>
.topbar {
    height: 60px;
    width: calc(100% - 250px);
    margin-left: 250px;
    background-color: #212529;
    padding: 10px 20px;
    color: white;
    position: fixed;
    top: 0;
    z-index: 1000;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
.topbar a {
    color: white;
    margin-left: 20px;
    font-size: 18px;
    text-decoration: none;
    position: relative;
}
.notification-badge {
    position: absolute;
    top: -5px;
    right: -10px;
    background: red;
    color: white;
    font-size: 10px;
    padding: 2px 5px;
    border-radius: 50%;
}
.dropdown-menu {
    min-width: 250px;
    max-height: 300px;
    overflow-y: auto;
    background-color: #343a40;
    color: white;
}
.dropdown-menu a {
    color: white;
}
</style>

<!-- Topbar content -->
<div class="topbar">
    <a href="settings.php" title="Settings"><i class="fas fa-cog"></i></a>

    <!-- Notification Dropdown -->
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" id="notifDropdown" data-bs-toggle="dropdown" title="Notifications">
            <i class="fas fa-bell"></i>
            <span id="notif-count" class="notification-badge">0</span>
        </a>
        <ul id="notif-list" class="dropdown-menu dropdown-menu-end shadow">
            <li><span class="dropdown-item text-muted">Loading...</span></li>
        </ul>
    </div>

    <a href="/stm_system/student/profile.php" title="Profile"><i class="fas fa-user"></i></a>
    <a href="/stm_system/auth/logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
</div>

<!-- jQuery + Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadNotifications() {
    $.ajax({
        url: "/stm_system/student/fetch_notifications.php",
        method: "GET",
        dataType: "json",
        success: function(data) {
            let notifList = $("#notif-list");
            notifList.empty();
            if (data.notifications.length === 0) {
                notifList.append(<li><span class="dropdown-item text-muted">No notifications</span></li>);
            } else {
                data.notifications.forEach(n => {
                    notifList.append(<li><a class="dropdown-item" href="#">🔔 ${n.message}<br><small class="text-muted">${n.time}</small></a></li>);
                });
                notifList.append(`
                    <li><hr class="dropdown-divider bg-secondary"></li>
                    <li><a href="#" id="clearAll" class="dropdown-item text-danger text-center">🗑 Clear All</a></li>
                    <li><a class="dropdown-item text-center text-warning" href="/stm_system/student/notifications.php">View All</a></li>
                `);
            }
            $("#notif-count").text(data.unread);
        }
    });
}
setInterval(loadNotifications, 10000);
loadNotifications();

$(document).on('click', '#clearAll', function(e) {
    e.preventDefault();
    if (confirm("Are you sure you want to clear all notifications?")) {
        $.ajax({
            url: "../student/clear_notifications.php",
            method: "POST",
            success: function(res) {
                loadNotifications();
            }
        });
    }
});
</script>