<main id="main" class="site-main" role="main">
    <div>
        MYSQL篇：
        <p>备份表：mysqldump -uroot -pxxx s_constant --force> /Users/binfang/test/s_constant0323</p>
        <p>恢复表：mysql -uroot -pxxx --set-gtid-purged=OFF < /Users/binfang/test/s_constant0314</p>
        <p>大表添加字段：pt-online-schema-change -h 127.0.0.1 -u root -p xxx --charset utf8  --alter "ADD COLUMN level_id INT(1) DEFAULT '0' COMMENT '客户成熟度'" D=twcrm\ v1.1.0,t=crm_customer_log_copy --execute</p>

        <div id="blogTitle">
            <h3>Mysql 通过frm&ibd 恢复数据</h3>
            <p>mysql存储在磁盘中，各种天灾人祸都会导致数据丢失。大公司的时候我们常常需要做好数据冷热备，对于小公司来说要做好所有数据备份需要支出大量的成本，很多公司也是不现实的。万一还没有做好备份，数据被误删除了，或者ibdata损坏了怎么办呢？别担心，只要有部分的frm、ibd存在就可以恢复部分数据。</p>
            <p>注意：</p>
            <p>一、这个是对innodb的数据恢复。myisam不需要这么麻烦，只要数据文件存在直接复制过去就可以。</p>
            <p>二、大家的mysql数据库必须是按表存放数据的，默认不是，但是大家生产肯定是按分表设置的吧，如果不是，不好意思，这个方法不能恢复你的数据。</p>
            <p>&nbsp; &nbsp; &nbsp; my.ini的设置为 innodb_file_per_table = 1。</p>
            <p><strong>1、找回表结构，如果表结构没有丢失直接到下一步</strong></p>
            <p style="margin-left: 30px">a、先创建一个数据库，这个数据库必须是没有表和任何操作的。</p>
            <p style="margin-left: 30px">b、创建一个表结构，和要恢复的表名是一样的。表里的字段无所谓。</p>
            <p style="margin-left: 30px">&nbsp;一定要是innodb引擎的。CREATE TABLE `<em id="__mceDel">ax_table</em>`( `weiboid` bigint(20)) ENGINE=InnoDB DEFAULT CHARSET=utf8;</p>
            <p style="margin-left: 30px">c、关闭mysql， service mysqld stop；&nbsp;</p>
            <p style="margin-left: 30px">d、用需要恢复的frm文件覆盖刚新建的frm文件；</p>
            <p style="margin-left: 30px">e、修改my.ini 里 innodb_force_recovery=1 ， 如果不成修改为 2,3,4,5,6。</p>
            <p style="margin-left: 30px">f、 启动mysql，service mysqld start；show create table <em id="__mceDel">ax_table</em>&nbsp;就能看到表结构信息了。</p>
            <p><strong>2、找回数据。记得上面把 innodb_force_recovery改掉了，需要注释掉，不然恢复模式不好操作。</strong></p>
            <p><strong>　　</strong><strong>这里有个关键的问题，就是innodb里的任何数据操作都是一个日志的记录点。</strong></p>
            <p><strong>　　</strong><strong>也就是如果我们需要数据恢复，必须把之前的表的数据的日志记录点添加到一致。</strong></p>
            <p style="margin-left: 30px">a、建立一个数据库，根据上面导出的创建表的sql执行创建表。</p>
            <p style="margin-left: 30px"><em id="__mceDel"></em><em id="__mceDel">b、找到记录点。先要把当前数据库的表空间废弃掉，使当前ibd的数据文件和frm分离。 ALTER TABLE ax_table DISCARD TABLESPACE;</em></p>
            <p style="margin-left: 30px"><em id="__mceDel"></em><em id="__mceDel">c、把之前要恢复的 .ibd文件复制到新的表结构文件夹下。 使当前的ibd 和frm发生关系。ALTER TABLE ax_table IMPORT TABLESPACE; &nbsp;</em></p>
            <p style="margin-left: 30px"><em id="__mceDel"></em><em id="__mceDel">这个时候没有错误，说明已经建立好了。如果能查到数据，到此就OK了，如果不行，请执行如下操作。</em></p>
            <p style="margin-left: 30px"><em id="__mceDel"></em><em id="__mceDel">d、相比这里大家已经知道为什么了，这个模式也不是说改了数据库就可以在生产环境使用。更改 innodb_force_recovery=1 ， 如果不成修改为 2,3,4,5,6。直到可以 查询出数据为止，然后dump出来。数据就备份出来了。</em></p>
            <p style="margin-left: 30px"><em id="__mceDel"></em><em id="__mceDel">e、把所有数据导出后，在新的数据库导入。所有数据就生成了。 &nbsp;</em></p>
        </div>
        </div>

</main>
<script>
    $(function(){


    });


</script>