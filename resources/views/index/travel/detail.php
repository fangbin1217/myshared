<link rel="stylesheet" href="<?php echo config('local')['website']; ?>/static/css/timeline/style.css" />
<style type="text/css">
    h2.top_title{border-bottom:none;text-align:center;line-height:32px; font-size:20px}
    h2.top_title span{font-size:12px; color:#666;font-weight:500}
</style>
<section id="cd-timeline" class="cd-container">

    <?php if ($travelInfo) { foreach ($travelInfo as $val){?>
    <div class="cd-timeline-block">
        <div class="cd-timeline-img cd-picture">
            <img src="<?php echo $val['randImage']; ?>" alt="Picture">
        </div>

        <div class="cd-timeline-content">
            <h2><?php echo $val['title']; ?></h2>
            <p><img src="<?php echo $val['image']; ?>" />
                <?php echo $val['content']; ?>
            </p>
            <span class="cd-date"><?php echo $val['utime']; ?></span>
        </div>
    </div>
    <?php }} ?>
</section>
<div class='cd-timeline-block' id="noMore" style="text-align:center;font-size: 20px;"><a href="javascript:;" id="getMore" >加载更多</a><img id="myLoading"  src="<?php echo config('local')['website']; ?>/static/image/common/timg.gif" /></div>

<script type="text/javascript">
    var pages = 2;
    var limit = <?php echo $limit; ?>;
    var id = <?php echo $id; ?>;

 $(document).ready(function () {
     $("#myLoading").hide();

    $('#getMore').click(function(){
        if (pages > 1) {
            $("#getMore").hide();
            $("#myLoading").show();
            $.getJSON("/travelmore", {page: pages, id:id}, function (json) {
                $("#myLoading").hide();
                $("#getMore").show();
                if (json) {
                    var obj = eval( json );
                    if (obj.success == true) {
                        var data = obj.data;
                        var count = data.length;
                        if (count > 0) {
                            var moreData = '';
                            for (var i in data) {
                                moreData += "<div class='cd-timeline-block'><div class='cd-timeline-img cd-picture'>";
                                moreData += "<img src='" + data[i].randImage + "' alt='Picture'></div><div class='cd-timeline-content'>";
                                moreData += "<h2>" + data[i].title + "</h2>";
                                moreData += "<p><img src=" + data[i].image + " />";
                                moreData += data[i].content + "</p>";
                                moreData += "<span class='cd-date'>" + data[i].utime + "</span></div></div>";
                            }
                            pages++;
                            $('#cd-timeline').append(moreData);

                            if (count < limit) {
                                pages = 1;
                                $('#noMore').html("<span>没有更多了</span>");
                            }
                        }
                    } else {
                        pages = 1;
                        $('#noMore').html("<span>没有更多了</span>");
                    }
                    //console.log(obj);
                }

            });
        }
    });
 });
</script>


