<form action="/%$appurl%/%$nameurl%/bind">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{ form.title }}</h4>
    </div>
    <div class="modal-body">
        {@while ($item in columns):}<div class="form-group">
            <label>{{ lang('%$app%.%$name%.{$item.colname}') }}</label>
        {{ input(form.{$item.merge_name}) }}
        </div>
        {@endwhile;}
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-save" data-dismiss="modal">{{ lang('admin.save') }}</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>

