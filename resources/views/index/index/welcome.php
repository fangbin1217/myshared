<main id="main" class="site-main" role="main">
                <div class="orderby"><ul><li class="order"><a href="javascript:void(0)" title="文章排序"><i class="be be-sort"></i></a></li></ul><ul class="order-box"><li><a href="javascript:;" rel="nofollow" title="按日期排序"><i class="be be-calendar2"></i></a></li><li><a href="javascript:;" rel="nofollow" title="随机排序"><i class="be be-repeat"></i></a></li><li><a href="javascript:;" rel="nofollow" title="按评论排序"><i class="be be-speechbubble"></i></a></li><li><a href="javascript:;" rel="nofollow" title="按浏览排序"><i class="be be-eye"></i></a></li><li><a href="javascript:;" rel="nofollow" title="按点赞排序"><i class="be be-thumbs-up"></i></a></li></ul></div>
                <?php if ($travelList) { foreach ($travelList as $val){?>
                <article id="post-6260" class="wow fadeInUp post-6260 post type-post status-publish format-standard hentry category-wzjs tag-1935 tag-29 tag-1960 tag-1961 tag-716 dfl" data-wow-delay="0.3s">
                    <figure class="thumbnail">
                        <a href="<?php echo $val['travelLink']; ?>"><img src="<?php echo $val['indexImage']; ?>" alt="" /></a> <span class="cat"><a href="<?php echo $val['travelLink']; ?>"><?php echo $val['tagName'];?></a></span>
                    </figure>
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php echo $val['travelLink']; ?>" rel="bookmark"><?php echo $val['title']; ?></a></h2> </header>
                    <div class="entry-content">
                        <div class="archive-content">
                            <?php echo $val['content']; ?> </div>
                        <span class="title-l"></span>
<span class="entry-meta">
<span class="date"><?php echo $val['utime'];?></span><span class="views"><i class="be be-eye"></i> 43</span><span class="comment"><a href="" rel="external nofollow"><i class="be be-speechbubble"></i> 7</a></span> </span>
                        <div class="clear"></div>
                    </div>
                    <span class="entry-more"><a href="<?php echo $val['travelLink']; ?>" rel="bookmark">阅读全文</a></span>
                </article>
                <?php }} ?>
                <!-- <div class="wow fadeInUp" data-wow-delay="0.3s">
                    <div class="ad-pc ad-site">
                    </div> </div> -->
            </main>
            <nav class="navigation pagination" role="navigation">
                <!--
                <h2 class="screen-reader-text">文章导航</h2>
                <div class="nav-links"><span aria-current='page' class='page-numbers current'><span class="screen-reader-text">第 </span>1<span class="screen-reader-text"> 页</span></span>
                    <a class='page-numbers' href='javascript:;'><span class="screen-reader-text">第 </span>2<span class="screen-reader-text"> 页</span></a>
                    <a class='page-numbers' href='javascript:;'><span class="screen-reader-text">第 </span>3<span class="screen-reader-text"> 页</span></a>
                    <a class='page-numbers' href='javascript:;'><span class="screen-reader-text">第 </span>4<span class="screen-reader-text"> 页</span></a>
                    <a class='page-numbers' href='javascript:;'><span class="screen-reader-text">第 </span>5<span class="screen-reader-text"> 页</span></a>
                    <span class="page-numbers dots">&hellip;</span>
                    <a class='page-numbers' href='javascript:;'><span class="screen-reader-text">第 </span>49<span class="screen-reader-text"> 页</span></a>
                    <a class="next page-numbers" href="javascript:;"><i class="be be-arrowright"></i></a></div>
            -->
            </nav>
