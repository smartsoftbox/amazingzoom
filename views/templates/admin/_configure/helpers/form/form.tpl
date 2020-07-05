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
      <input class="range-slider" type="range"
             value="{if isset($input.string_format) && $input.string_format}{$value_text|string_format:$input.string_format|escape:'html':'UTF-8'}{else}{$value_text|escape:'html':'UTF-8'}{/if}"
              {if isset($input.size)} min="{$input.size|intval}"{/if}
              {if isset($input.maxchar) && $input.maxchar} max="{$input.maxchar|intval}"{/if}
              {if isset($input.maxlength) && $input.maxlength} step="{$input.maxlength|intval}"{/if}
             data-buffer="0"/>
      <input class="input-range-slider" type="text"
             name="{$input.name}"
             id="{if isset($input.id)}{$input.id}{else}{$input.name}{/if}"
             value="{if isset($input.string_format) && $input.string_format}{$value_text|string_format:$input.string_format|escape:'html':'UTF-8'}{else}{$value_text|escape:'html':'UTF-8'}{/if}"
             class="{if isset($input.class)}{$input.class}{/if}{if $input.type == 'tags'} tagify{/if}"
              {if isset($input.readonly) && $input.readonly} readonly="readonly"{/if}
              {if isset($input.disabled) && $input.disabled} disabled="disabled"{/if}
              {if isset($input.autocomplete) && !$input.autocomplete} autocomplete="off"{/if}
              {if isset($input.required) && $input.required } required="required" {/if}
              {if isset($input.placeholder) && $input.placeholder } placeholder="{$input.placeholder}"{/if}
      />
    {else}
        {$smarty.block.parent}
    {/if}

{/block}
