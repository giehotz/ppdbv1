/**
 * Notification System JavaScript
 * Handles announcement notifications in student portal header
 */

// Configuration
const BASE_URL = window.location.origin;
const NOTIFICATION_API = {
    count: `${BASE_URL}/api/notifikasi/count`,
    recent: `${BASE_URL}/api/notifikasi/recent`
};

const REFRESH_INTERVAL = 30000; // 30 seconds

// State
let notificationInterval = null;
let isDropdownOpen = false;

/**
 * Fetch and update notification count
 */
async function fetchNotificationCount() {
    try {
        const response = await fetch(NOTIFICATION_API.count);
        const data = await response.json();

        if (data.success) {
            const lastReadCount = parseInt(localStorage.getItem('notif_read_count') || '0');
            const unreadCount = Math.max(0, data.count - lastReadCount);
            updateNotificationBadge(unreadCount);
        }
    } catch (error) {
        console.error('Error fetching notification count:', error);
    }
}

/**
 * Update notification badge display
 */
function updateNotificationBadge(count) {
    const badge = document.getElementById('notification-badge');

    if (count > 0) {
        badge.textContent = count > 9 ? '9+' : count;
        badge.classList.remove('hidden');
    } else {
        badge.classList.add('hidden');
    }
}

/**
 * Mark all current notifications as read
 */
async function markNotificationsAsRead() {
    try {
        const response = await fetch(NOTIFICATION_API.count);
        const data = await response.json();

        if (data.success) {
            localStorage.setItem('notif_read_count', data.count.toString());
            updateNotificationBadge(0);
        }
    } catch (error) {
        console.error('Error marking notifications as read:', error);
    }
}

/**
 * Fetch recent announcements for dropdown
 */
async function fetchRecentAnnouncements() {
    try {
        const response = await fetch(NOTIFICATION_API.recent);
        const data = await response.json();

        if (data.success) {
            renderAnnouncementDropdown(data.announcements);
        }
    } catch (error) {
        console.error('Error fetching announcements:', error);
    }
}

/**
 * Render announcement dropdown content
 */
function renderAnnouncementDropdown(announcements) {
    const container = document.getElementById('notification-dropdown-content');

    if (!announcements || announcements.length === 0) {
        container.innerHTML = `
            <div class="px-4 py-8 text-center text-gray-500">
                <i class="fas fa-inbox text-3xl mb-2"></i>
                <p>Tidak ada pengumuman</p>
            </div>
        `;
        return;
    }

    const typeColors = {
        'general': 'blue',
        'ujian': 'yellow',
        'kelulusan': 'green'
    };

    const typeIcons = {
        'general': 'fa-bullhorn',
        'ujian': 'fa-file-alt',
        'kelulusan': 'fa-graduation-cap'
    };

    const html = announcements.map(announcement => {
        const color = typeColors[announcement.tipe] || 'gray';
        const icon = typeIcons[announcement.tipe] || 'fa-bullhorn';
        const date = new Date(announcement.publish_date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric'
        });

        return `
            <a href="${window.location.origin}/siswa/pengumuman" 
               class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-100 last:border-0">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-${color}-100 text-${color}-800">
                            <i class="fas ${icon} mr-1"></i>
                            ${announcement.tipe.charAt(0).toUpperCase() + announcement.tipe.slice(1)}
                        </span>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-800 line-clamp-2">
                            ${escapeHtml(announcement.judul)}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="far fa-calendar mr-1"></i>${date}
                        </p>
                    </div>
                </div>
            </a>
        `;
    }).join('');

    container.innerHTML = html;
}

/**
 * Toggle notification dropdown
 */
function toggleNotificationDropdown() {
    const dropdown = document.getElementById('notification-dropdown');
    isDropdownOpen = !isDropdownOpen;

    if (isDropdownOpen) {
        dropdown.classList.remove('hidden');
        fetchRecentAnnouncements();
        // Mark as read when dropdown is opened
        markNotificationsAsRead();
    } else {
        dropdown.classList.add('hidden');
    }
}

/**
 * Close dropdown when clicking outside
 */
document.addEventListener('click', function (event) {
    const notificationButton = document.getElementById('notification-button');
    const dropdown = document.getElementById('notification-dropdown');

    if (!notificationButton?.contains(event.target) && !dropdown?.contains(event.target)) {
        if (isDropdownOpen) {
            dropdown?.classList.add('hidden');
            isDropdownOpen = false;
        }
    }
});

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Initialize notification system
 */
function initNotifications() {
    // Initial fetch
    fetchNotificationCount();

    // Set up auto-refresh
    notificationInterval = setInterval(fetchNotificationCount, REFRESH_INTERVAL);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function () {
    initNotifications();
});

// Clean up interval when page unloads
window.addEventListener('beforeunload', function () {
    if (notificationInterval) {
        clearInterval(notificationInterval);
    }
});
