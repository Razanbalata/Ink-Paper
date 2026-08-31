console.log("🔔 notifications.js loaded");

const userId = document.querySelector('meta[name="user-id"]')?.content;

console.log("👤 User ID:", userId);
console.log("📡 Echo:", window.Echo);

if (userId && window.Echo) {
    const channelName = `App.Models.User.${userId}`;

    console.log("📡 Subscribing to:", channelName);

    const channel = window.Echo.private(channelName);

    console.log("📡 Channel:", channel);

    channel.notification((notification) => {
        console.log("🔔🔔 NOTIFICATION RECEIVED:", notification);

        updateUnreadCount();
        addNotificationToDropdown(notification);
        showNotificationToast(notification);
    });

    console.log("✅ Notification listener registered");
}

function updateUnreadCount() {
    const badge = document.getElementById("notification-unread-count");

    if (!badge) {
        console.log("⚠️ Notification badge not found");
        return;
    }

    let count = parseInt(badge.dataset.count || "0", 10);

    count++;

    badge.dataset.count = count;

    badge.textContent = count > 99 ? "99+" : count;

    badge.classList.remove("hidden");

    console.log("🔴 Unread count:", count);
}

function addNotificationToDropdown(notification) {
    const list = document.getElementById("notifications-list");

    if (!list) {
        console.log("⚠️ Notifications list not found");
        return;
    }

    const notificationElement = document.createElement("div");

    notificationElement.className = "bg-paper/40 transition-all duration-300";

    const icon = notification.type?.includes("ReactionReceived")
        ? `
            <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M20.8 8.8c0 5.5-8.8 10.2-8.8 10.2S3.2 14.3 3.2 8.8A4.8 4.8 0 0 1 8 4a5.2 5.2 0 0 1 4 2.1A5.2 5.2 0 0 1 16 4a4.8 4.8 0 0 1 4.8 4.8Z"
                />
            </svg>
        `
        : `
            <svg class="h-4 w-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M21 11.5a8.4 8.4 0 0 1-8.9 8.4A8.5 8.5 0 0 1 3 11.5a8.5 8.5 0 0 1 8.5-8.5a8.5 8.5 0 0 1 8.5 8.5Z"
                />
                <path
                    stroke-linecap="round"
                    stroke-width="1.8"
                    d="M8 11.5h8"
                />
            </svg>
        `;

    notificationElement.innerHTML = `
        <div class="flex w-full gap-3 px-4 py-3 text-left">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-paper">
                ${icon}
            </div>

            <div class="min-w-0 flex-1">

                <p class="text-sm font-medium leading-5 text-ink">
                    ${notification.message ?? "You have a new notification."}
                </p>

                ${
                    notification.post_title
                        ? `
                            <p class="mt-0.5 truncate text-xs text-muted">
                                ${notification.post_title}
                            </p>
                        `
                        : ""
                }

                <div class="mt-1 flex items-center justify-between">

                    <span class="text-[11px] text-muted">
                        Just now
                    </span>

                    <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>

                </div>

            </div>

        </div>
    `;

    list.prepend(notificationElement);

    // Remove empty state if it exists
    const emptyState = list.querySelector("[data-notifications-empty]");

    if (emptyState) {
        emptyState.remove();
    }

    // Keep only latest 5
    while (list.children.length > 5) {
        list.lastElementChild.remove();
    }

    console.log("✅ Notification added to dropdown");
}

function showNotificationToast(notification) {
    const container = document.getElementById("notification-toast-container");

    if (!container) {
        console.log("⚠️ Toast container not found");
        return;
    }

    const toast = document.createElement("div");

    toast.className = `
        translate-x-5 opacity-0
        rounded-2xl border border-border
        bg-white p-4 shadow-xl
        transition-all duration-300
    `;

    toast.innerHTML = `
        <div class="flex items-start gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-paper">
                <svg
                    class="h-5 w-5 text-primary"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-width="1.8"
                        d="M15 17h5l-1.5-1.5V11a6.5 6.5 0 0 0-13 0v4.5L4 17h5m6 0a3 3 0 0 1-6 0"
                    />
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold text-ink">
                    New notification
                </p>

                <p class="mt-1 text-sm leading-5 text-muted">
                    ${notification.message ?? "You have a new notification."}
                </p>

                ${
                    notification.post_title
                        ? `
                            <p class="mt-1 truncate text-xs text-muted">
                                ${notification.post_title}
                            </p>
                        `
                        : ""
                }
            </div>

            <button
                type="button"
                class="shrink-0 text-muted transition hover:text-ink"
                aria-label="Close notification"
            >
                ✕
            </button>

        </div>
    `;

    container.prepend(toast);

    // Animate in
    requestAnimationFrame(() => {
        toast.classList.remove("translate-x-5", "opacity-0");
    });

    // Close button
    const closeButton = toast.querySelector("button");

    closeButton.addEventListener("click", () => {
        removeToast(toast);
    });

    // Automatically remove after 5 seconds
    setTimeout(() => {
        removeToast(toast);
    }, 5000);
}

function removeToast(toast) {
    toast.classList.add('translate-x-5', 'opacity-0');

    setTimeout(() => {
        toast.remove();
    }, 300);
}