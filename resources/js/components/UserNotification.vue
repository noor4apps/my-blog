<template>

    <li class="shopcart">
        <a class="cartbox_active" href="#">
            <span class="product_qun" v-if="unreadCount > 0">{{unreadCount}}</span>
        </a>
        <!-- Start Shopping Cart -->
        <div class="block-minicart minicart__active">
            <div class="minicart-content-wrapper" v-if="unreadCount > 0">
                <div class="single__items">
                    <div class="miniproduct">

                        <div class="item01 d-flex mt--20" v-for="item in unread" :key="item.id">
                            <div class="thumb">
                                <a :href="`edit-comment/${item.data.id}`" @click="readNotifications(item)"><img src="/frontend/images/icons/comment.png" alt="`${item.data.post_title}`"></a>
                            </div>
                            <div class="content">
                                <a :href="`edit-comment/${item.data.id}`" @click="readNotifications(item)">You have new comment on your post: {{ item.data.post_title }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Shopping Cart -->
    </li>
</template>

<script>
    export default {
        data: function () {
            return {
                read: {},
                unread: {},
                unreadCount: 0
            }
        },
        created: function () {
            this.getNotifications();

            let userId = $('meta[name="userId"]').attr('content');
            // Get a private channel instance by name.
            Echo.private('App.User.' + userId)
                // Listen for an event on the channel instance.
                .notification((notification) => {
                    // Add items to the beginning of an array.
                    this.unread.unshift(notification);
                    this.unreadCount++;
                });
        },
        methods: {
            getNotifications() {
                axios.get('user/notifications/get').then(res => {
                    // res: {data: {…}, status: 200, statusText: "OK", headers: {…}, config: {…}, …}
                    // data: {read: Array(size), unread: Array(size), usertype: "user"}
                    this.read = res.data.read;
                    this.unread = res.data.unread;
                    this.unreadCount = res.data.unread.length;
                }).catch(error => Exception.handle(error))
            },
            readNotifications(notification) {
                axios.post('user/notifications/read', {id: notification.id}).then(res => {
                    // notification: {…}|,created_at: ("2021-06-03T...), data: (Object), id: (2a4bbbc4...), notifiable_id: (4), notifiable_type: ("App\\Models\\User"), read_at: (null), type: ("App\\Notifications\\NewCommentForPostOwnerNotify"), updated_at: ("2021-06-0...)
                    // Removes elements from an array splice(start: number, deleteCount?: number): T[];
                    this.unread.splice(notification,1);
                    // Add items to the end of an array.
                    this.read.push(notification);
                    this.unreadCount--;
                })
            }
        }
    }
</script>
