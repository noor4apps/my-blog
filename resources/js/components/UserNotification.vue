<template>
    <li class="shopcart"><a class="cartbox_active" href="#">
        <span class="product_qun" v-if="unreadCount > 0">{{ unreadCount }}</span>
    </a>
        <!-- Start Shopping Cart -->
        <div class="block-minicart minicart__active">
            <div class="minicart-content-wrapper" v-if="unreadCount > 0">
                <div class="single__items">
                    <div class="miniproduct">

                        <div class="item01 d-flex mt--20" v-for="item in unread" :key="item.id">
                            <div class="thumb">
                                <a :href="`${item.data.post_slug}`" @click="readNotifications(item)"><img src="/frontend/images/icons/comment.png" alt="`${ item.data.post_title }`"></a>
                            </div>
                            <div class="content">
                                <h6><a :href="`${item.data.post_slug}`" @click="readNotifications(item)">You have new comment on your post: {{ item.data.post_title }}</a></h6>
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
                read:{},
                unread:{},
                unreadCount: 0,
            }
        },
        created: function () {
            this.getNotification();

            let userId = $('meta[name="userId"]').attr('content');
            Echo.private('App.User.' + userId).notification((noti) => {
                this.unread.unshift(noti);
                this.unreadCount++;
            });
        },

        methods: {
            getNotification() {
                axios.get('user/notifications/get').then(res => {
                    this.read = res.data.read;
                    this.unread = res.data.unread;
                    this.unreadCount = res.data.unread.length;
                }).catch(error => Exception.handle(error))
            },
            readNotifications(notification) {
                axios.post('user/notification/read', {id: notification.id}).then(res => {
                    this.unread.splice(notification, 1);
                    this.read.push(notification);
                    this.unreadCount--;
                })
            }
        }

    }
</script>
