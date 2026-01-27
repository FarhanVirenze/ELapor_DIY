self.addEventListener("push", function (event) {
    if (!(self.Notification && self.Notification.permission === "granted")) {
        return;
    }

    const payload = event.data ? event.data.json() : {};
    const title = payload.title || "E-Lapor DIY";
    const options = {
        body: payload.body || "Ada notifikasi baru.",
        icon: "/images/logo-diy.png",
        badge: "/images/logo-diy.png",
        data: {
            url: payload.action_url || "/",
        },
        actions: payload.actions || [],
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

self.addEventListener("notificationclick", function (event) {
    event.notification.close();
    event.waitUntil(
        clients
            .matchAll({ type: "window", includeUncontrolled: true })
            .then(function (clientList) {
                if (clientList.length > 0) {
                    let client = clientList[0];
                    for (let i = 0; i < clientList.length; i++) {
                        if (clientList[i].focused) {
                            client = clientList[i];
                        }
                    }
                    return client
                        .focus()
                        .then(() =>
                            client.navigate(event.notification.data.url),
                        );
                }
                return clients.openWindow(event.notification.data.url);
            }),
    );
});
