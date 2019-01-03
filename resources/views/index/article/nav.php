<?php
?>
<main id="main" class="site-main" role="main">
    <article  class="tag-xss tag-3122 dfl">
        <?php
        foreach ($list as $val) {
            echo "<div  style='text-align: left'><a href='/article/detail/".$val['id']."'><img style='width:32px;height:32px;' src='".$val['image']."' /> <span style='font-size: 24'>".$val['name']."</span></a></div></hr>";
        }
        ?>    </article>

</main>
