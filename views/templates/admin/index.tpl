{*
*  @author Marcin Kubiak
*  @copyright  Smart Soft
*  @license    Commercial license
*  International Registered Trademark & Property of Smart Soft
*}

<div class="row" id="amazingZoom" xmlns="http://www.w3.org/1999/html">
  <div class="col-lg-12">
    <div class="row">
      <div class="col-lg-2">
        <div class="list-group" id="amazingzooms">
            {foreach from=$pages item=page name=page}
              <a href="#" id="{$page.id_amazingzoom|intval}" class="amazingzoom-tab list-group-item">

                <span class="{if $page.id_amazingzoom == 1}bold{/if}">{$page.name|escape:'htmlall':'UTF-8'}</span>
                  {if $page.name != 'Default Settings'}
                    <i class="icon-gear {if !$page.use_default}active{/if}"></i>
                  {/if}
                  {if $page.name != 'Default Settings'}
                    <i id="xzoom" class="icon-circle {if $page.swipe_is_enable}active{/if}"></i>
                  {/if}
                  {if $page.name != 'Default Settings'}
                    <i id="swipe" class="icon-circle {if $page.is_enable}active{/if}"></i>
                  {/if}
              </a>
            {/foreach}
          <a href="#" id="welcome" class="list-group-item"><b>Documentation</b></a>
        </div>
      </div>
      <div id="right-column" class="form-horizontal col-lg-10">
        <div id="ajax-loader">
           <div class="yellow"></div>
          <div class="violet"></div>
          <div class="blue"></div>
          <div class="red"></div>
        </div>
          {foreach from=$pages item=page name=pagee}
            <div alt="{$page.id_amazingzoom|intval}" class="tab-content list-group">
              <div alt="model-{$page.id_amazingzoom|intval}"></div>
            </div>
          {/foreach}
        <div alt="welcome" class="tab-content list-group">
            {include file=$start}
        </div>
      </div>
    </div>
  </div>
</div>

