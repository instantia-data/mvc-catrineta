<form action="/%$appurl%/filter_%$nameurl%/">
    {@while ($item in columns):}<div class="form-group">
        <label>{{ form.{$item.colname}.label }}</label>
        {{ form.{$item.colname}.input }}
    </div>
    {@endwhile;}
    <div>
        <button type="submit" class="btn btn-default btn-filter">{{ lang('admin.filter') }}</button>
        <button type="reset" class="btn btn-default btn-reset">{{ lang('admin.clean') }}</button>
    </div>
</form>

