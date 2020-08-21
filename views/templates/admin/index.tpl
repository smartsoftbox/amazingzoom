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
                <i class="icon-circle is_enable {if $page.is_enable}active{/if}"></i>
                <i class="icon-circle swipe_is_enable {if $page.swipe_is_enable}active{/if}"></i>
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


<div id="dsDialog" class="modal fade" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Please select settings you want copy</h4>
      </div>


      <div class="modal-body">
        <div class="list-group"">
          {foreach from=$pages item=page name=page}
            <a href="#" id="copy-{$page.id_amazingzoom|intval}" class="amazingzoom-tab list-group-item">
              <span>{$page.name|escape:'htmlall':'UTF-8'}</span>
            </a>
          {/foreach}
        </div>
      </div>
    </div>
  </div>
</div>

