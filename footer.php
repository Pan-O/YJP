        </div>
        <footer class="site-footer clearfix u-textAlignCenter">
            <P>Theme：<a href="https://github.com/coolapk-Panjianhao/YJP" target="_blank">YJP</a></P>
            <?php if ( yjp_option('web_run_time') == '1') { ?><p id="run_time"></p>
            <script>function runtime(){
        X = new Date("<?php echo yjp_option('build_time'); ?>");
        Y = new Date();
        T = (Y.getTime()-X.getTime());
        M = 24*60*60*1000;
        a = T/M;
        A = Math.floor(a);
        b = (a-A)*24;
        B = Math.floor(b);
        c = (b-B)*60;
        C = Math.floor((b-B)*60);
        D = Math.floor((c-C)*60);
        run_time.innerHTML = "<?php echo yjp_option('web_name'); ?>已经存活"+A+"天"+B+"小时"+C+"分"+D+"秒"
    }
    setInterval(runtime, 1000);
</script><?php } ?>
<?php echo yjp_option('footer_main'); ?>
        </footer>
    </div>
    <a href="javascript:NightMode()" target="_self" id="night-button"><i class="iconfont icon-night_light"></i></a>
    <div class="back2top"><svg class="icon" viewBox="0 0 1229 1024" xmlns:xlink="http://www.w3.org/1999/xlink" width="19.203125" height="16"><defs><style type="text/css"></style></defs><path d="M955.765399 614.591058v408.726594h-682.348237V614.591058h-273.416939l614.591057-614.591058 614.591058 614.591058H955.765399z" fill="" ></path></svg></div>
    <?php wp_footer(); ?>
</body>
</html>