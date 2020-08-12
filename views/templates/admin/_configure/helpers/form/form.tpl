{**
* 2016 Smart Soft
*
*  @author    Marcin Kubiak <zlecenie@poczta.onet.pl>
*  @copyright Smart Soft
*  @license   Commercial License
*  International Registered Trademark & Property of Smart Soft
*}

{extends file="helpers/form/form.tpl"}

{block name="input"}

    {if $input.type == 'slider'}
        {assign var='value_text' value=$fields_value[$input.name]}
      <span class="slider-min">{if isset($input.size)} {$input.size|intval}{/if}</span>
      <input class="range-slider" type="range"
             value="{if isset($input.string_format) && $input.string_format}{$value_text|string_format:$input.string_format|escape:'html':'UTF-8'}{else}{$value_text|escape:'html':'UTF-8'}{/if}"
              {if isset($input.size)} min="{$input.size|intval}"{/if}
              {if isset($input.maxchar) && $input.maxchar} max="{$input.maxchar|intval}"{/if}
              {if isset($input.maxlength) && $input.maxlength} step="{$input.maxlength|intval}"{/if}
             data-buffer="{$value_text|escape:'html':'UTF-8'}"/>
      <span class="slider-max">{if isset($input.maxchar) && $input.maxchar} {$input.maxchar|intval}{/if}</span>
      <span class="slider-value">value:</span>
      <input class="value-range-slider" type="text"
             name="{$input.name}"
             id="{if isset($input.id)}{$input.id|intval}{else}{$input.name|escape:'html':'UTF-8'}{/if}"
             value="{if isset($input.string_format) && $input.string_format}{$value_text|string_format:$input.string_format|escape:'html':'UTF-8'}{else}{$value_text|escape:'html':'UTF-8'}{/if}"
             class="{if isset($input.class)}{$input.class|escape:'html':'UTF-8'}{/if}{if $input.type == 'tags'} tagify{/if}"
              {if isset($input.readonly) && $input.readonly} readonly="readonly"{/if}
              {if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}
              {if isset($input.autocomplete) && !$input.autocomplete} autocomplete="off"{/if}
              {if isset($input.required) && $input.required } required="required" {/if}
              {if isset($input.placeholder) && $input.placeholder } placeholder="{$input.placeholder|escape:'html':'UTF-8'}"{/if}
      />
    {elseif $input.type == 'radio-icon'}
        {foreach name=value from=$input.values item=value}
          <div style="margin-bottom:8px;" class="radio
              {if $smarty.foreach.value.first} radio-first {/if}
              {if $smarty.foreach.value.last} radio-last {/if}
              {if isset($input.class)}{$input.class}{/if} {$value.id|intval} {if $fields_value[$input.name] == $value.value}active{/if}">
              {strip}
                <span class="icon"></span>
                <label style="padding-left: 5px;">
                  <input style="display: none;" type="radio" name="{$input.name|escape:'html':'UTF-8'}" id=""
                         value="{$value.value|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if}{if (isset($input.disabled) && $input.disabled) or (isset($value.disabled) && $value.disabled)} disabled="disabled"{/if}/>
                    {$value.label|escape:'html':'UTF-8'}
                </label>
              {/strip}
          </div>
        {/foreach}
      <div style="clear: both;"></div>
        {if isset($value.p) && $value.p}<p class="help-block">{$value.p|escape:'html':'UTF-8'}</p>{/if}
    {elseif $input.type == 'duallist'}
      <div class="dual-list list-left col-md-5" style="padding-left: 0px;">
        <div class="well text-right">
          <div class="row">
            <div class="col-md-10">
              <div class="input-group">
                <span class="input-group-addon glyphicon-search">
                    <i class="icon-search"></i>
                </span>
                <input type="text" name="SearchDualList" class="form-control" placeholder="search"/>
              </div>
            </div>
            <div class="col-md-2">
              <div class="btn-group">
                <a class="btn btn-default button selector" title="select all">
                  all
                </a>
              </div>
            </div>
          </div>
          <div class="row">
            <ul class="list-group" style="height: 400px; overflow: auto">
                {foreach $input.options.options.query as $option}
                    {if !$option|in_array:$fields_value[$input.name]}
                      <li id="option-{$option[$input.options.options.id]|escape:'htmlall':'UTF-8'}"
                          class="list-group-item">
                        <span>{$option[$input.options.options.name]|escape:'htmlall':'UTF-8'}</span>
                        <span class="float-right">
                          <a href="{$option[$input.options.options.link]|escape:'htmlall':'UTF-8'}" target="_blank">
                            <i class="icon-link"></i>
                          </a>
                        </span>
                      </li>
                    {/if}
                {/foreach}
            </ul>
          </div>
        </div>
      </div>
      <div class="list-arrows col-md-1 text-center">
        <a href="#" class="btn btn-default btn-sm button move-left"><<</a>
        <a href="#" class="btn btn-default btn-sm button move-right">>></a>
      </div>
      <div class="dual-list list-right col-md-5">
        <div class="well">
          <div class="row">
            <div class="col-md-10">
              <div class="input-group">
                <span class="input-group-addon glyphicon-search">
                    <i class="icon-search"></i>
                </span>
                <input type="text" name="SearchDualList" class="form-control" placeholder="search"/>
              </div>
            </div>
            <div class="col-md-2">
              <div class="btn-group">
                <a class="btn btn-default button selector" id="select_all" title="select all">
                  all
                </a>
              </div>
            </div>
          </div>
          <div class="row">
            <ul class="list-group" style="height: 400px; overflow: auto">
                {foreach $input.options.options.query as $option}
                    {if $option.page|in_array:$fields_value[$input.name]}
                      <li id="option-{$option[$input.options.options.id]|escape:'htmlall':'UTF-8'}"
                          class="list-group-item">
                        <span>{$option[$input.options.options.name]|escape:'htmlall':'UTF-8'}</span>
                        <span class="float-right">
                          <a href="{$option[$input.options.options.link]|escape:'htmlall':'UTF-8'}" target="_blank">
                            <i class="icon-link"></i>
                          </a>
                        </span>
                      </li>
                    {/if}
                {/foreach}
            </ul>
            <input type="hidden" name="{$input.name|escape:'htmlall':'UTF-8'}" id="{$input.id|escape:'htmlall':'UTF-8'}"
                   value="{', '|implode:$fields_value[$input.name]}"/>
          </div>
        </div>
      </div>
    {else}
        {$smarty.block.parent}
    {/if}

{/block}

{block name="autoload_tinyMCE"}
{/block}
