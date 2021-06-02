<template>
    <li class="shopcart"><a class="cartbox_active" href="#"><span class="product_qun">3</span></a>
        <!-- Start Shopping Cart -->
        <div class="block-minicart minicart__active">
            <div class="minicart-content-wrapper">
                <div class="single__items">
                    <div class="miniproduct">
                        <div class="item01 d-flex mt--20">
                            <div class="thumb">
                                <a href="product-details.html"><img src="{{ asset('assets/posts/default_small.jpg') }}" width="50" height="50" alt="product images"></a>
                            </div>
                            <div class="content">
                                <h6><a href="product-details.html">You have new comment on your post: post title</a></h6>
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
            let userId = $('meta[name="userId"]').attr('content');
            Echo.private('App.User.' + userId)
                .notification((noti) => {
                    this.unread.unshift(noti);
                    this.unreadCount++;
                });
        },

        methods: {
            getNotification() {
                axios.get('user/notifications/get')
            }
        }
    }
</script>
