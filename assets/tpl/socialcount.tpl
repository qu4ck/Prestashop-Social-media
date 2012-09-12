<ul class="socialcount">
    <li>
        <div class="fb-like" data-send="false" {if {$fb[0]} != 'standart'}data-layout="{$fb[0]}"{/if} {if {$fb[0]} == 'standart'}data-width="{$fb[1]}"{/if} data-show-faces="false" data-font="{$fb[3]}" data-action="{$fb[2]}"></div>
    </li>
    <li>
        <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-count="{if {$tw[2]} == 'none' && {$tw[0]} == 'horizontal'}{else}{$tw[0]}{/if}" {if {$tw[1]} !=""} data-via="{$tw[1]}" {/if} {if {$tw[3]} !=""}data-size="large"{/if}>Tweet</a>
        {literal}
        <script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        {/literal}
    </li>
    <li>
        <g:plusone size="{$gp[0]}" {if {$gp[1]} != 'none'} annotation="{$gp[1]}" {/if} {if $gp[1] == 'inline'}width{/if}></g:plusone>
        <script type="text/javascript">
          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
        </script>
    </li>
</ul>
