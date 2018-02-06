<main id="main" class="site-main" role="main">
                <div class="orderby"><ul><li class="order"><a href="javascript:void(0)" title="文章排序"><i class="be be-sort"></i></a></li></ul><ul class="order-box"><li><a href="javascript:;" rel="nofollow" title="按日期排序"><i class="be be-calendar2"></i></a></li><li><a href="javascript:;" rel="nofollow" title="随机排序"><i class="be be-repeat"></i></a></li><li><a href="javascript:;" rel="nofollow" title="按评论排序"><i class="be be-speechbubble"></i></a></li><li><a href="javascript:;" rel="nofollow" title="按浏览排序"><i class="be be-eye"></i></a></li><li><a href="javascript:;" rel="nofollow" title="按点赞排序"><i class="be be-thumbs-up"></i></a></li></ul></div>
    <?php if ($list) {?>
    <article id="post-6260" class="wow fadeInUp post-6260 post type-post status-publish format-standard hentry category-wzjs tag-1935 tag-29 tag-1960 tag-1961 tag-716 dfl" data-wow-delay="0.3s" >
                    <figure>
                        <a href="javascript:;" style="color: rgb(255, 102, 0);font-weight: bold;font-size:18px;">    <?php echo $list['title'];?>&nbsp;<a style="float:right;font-size:18px;folor:#765;" href="<?php echo config('local')['website'].'/article/babystory?rand='.$list['id']; ?>">换一个</a></a>
                    </figure>
                    <div class="entry-content" style="color:#777;font-size:18px;">
                        <?php echo $list['content'];?>
                        <div class="clear"></div>
                    </div>
                </article>
    <?php }?>


</main>
<script>
    $(function(){


    });


</script>