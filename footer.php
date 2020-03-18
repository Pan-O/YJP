        </div>
        <footer class="site-footer clearfix u-textAlignCenter">
            <P>Theme：<a href="https://panjianhao.top/" target="_blank">YJP</a></P>
            <?php if ( yjp_option('web_run_time') == '1') { ?><P><?php echo yjp_option('web_name'); ?>已经存活<span id="run_time"></span></P>
            <script>function runTime() {
    var d = new Date(), str = '';
    BirthDay = new Date("<?php echo yjp_option('build_time'); ?>");
    today = new Date();
    timeold = (today.getTime() - BirthDay.getTime());
    sectimeold = timeold / 1000
    secondsold = Math.floor(sectimeold);
    msPerDay = 24 * 60 * 60 * 1000
    msPerYear = 365 * 24 * 60 * 60 * 1000
    e_daysold = timeold / msPerDay
    e_yearsold = timeold / msPerYear
    daysold = Math.floor(e_daysold);
    yearsold = Math.floor(e_yearsold);
    str += daysold + "天";
    str += d.getHours() + '时';
    str += d.getMinutes() + '分';
    str += d.getSeconds() + '秒';
    return str;
}
setInterval(function () {
    $('#run_time').html(runTime())
}, 1000);</script><?php } ?>
<?php echo yjp_option('footer_main'); ?>
        </footer>
    </div>
    <a href="javascript:NightMode()" target="_self" id="night-button"><i class="iconfont icon-night_light"></i></a>
    <div class="back2top"><svg class="icon" viewBox="0 0 1229 1024" xmlns:xlink="http://www.w3.org/1999/xlink" width="19.203125" height="16"><defs><style type="text/css"></style></defs><path d="M955.765399 614.591058v408.726594h-682.348237V614.591058h-273.416939l614.591057-614.591058 614.591058 614.591058H955.765399z" fill="" ></path></svg></div>
    <?php wp_footer(); ?>
</body>
</html>