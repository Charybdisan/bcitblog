<div class="control-group">
    <label class="control-label" for="{name}"><h3>{label}</h3></label>
    <div class="controls">
        <select id="{name}" name="{name}" value="{value}" maxLength="{maxlen}" style="width:{size}em" {disabled}>
                {options}
                <option value="{val}" {selected}>{display}</option>
            {/options}
        </select>
        <small>{explain}</small>
    </div>
</div>
