<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" data-id="table-%$name%">
        <thead>
            <tr>
                {@while ($item in columns):}
                <th>{{ lang('%$app%.%$name%.{$item.colname}') }}</th>{@endwhile;}
                <th></th>
                <th></th>
            </tr> 
        </thead>
        <tbody>
            <tr data-id="%$id%" style="display: none">
                <th>#</th>{@while ($item in columns):}
                <td data-field="{$item.column}"></td>{@endwhile;}
                <td class="icon-cell">
                    <a data-action="/%$appurl%/%$nameurl%/edit" 
                       title="{{ lang('admin.edit') }}" class="btn-edit fa fa-pencil"></a>
                </td>
                <td class="icon-cell">
                    <a data-action="/%$appurl%/%$nameurl%/delete" 
                       title="{{ lang('admin.delete') }}" class="btn-edit fa fa-trash-o"></a>
                </td>
            </tr>
            {% for item in list %}
            <tr data-id="{{ item['%$id%'] }}">
                <th>#</th>{@while ($item in columns):}
                <td data-field="{$item.column}">{{ item['{$item.column}'] }}</td>{@endwhile;}
                <td class="icon-cell">
                    <a data-action="/%$appurl%/%$nameurl%/edit/{{ item['%$id%'] }}" 
                       title="{{ lang('admin.edit') }}" class="btn-edit fa fa-pencil"></a>
                </td>
                <td class="icon-cell">
                    <a data-action="/%$appurl%/%$nameurl%/delete/{{ item['%$id%'] }}" 
                       title="{{ lang('admin.delete') }}" class="btn-edit fa fa-trash-o"></a>
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="dataTables_info" role="status" aria-live="polite">
            {{ lang('admin.table-resume')|format(resume.start, resume.end, resume.total) }}
        </div> 
    </div>
    <div class="col-sm-6">
        <div class="dataTables_paginate paging_simple_numbers">
            <ul class="pagination">
                <li class="paginate_button previous {{ resume.previous }}" tabindex="0">
                    <a href="#">{{ lang('admin.previous') }}</a>
                </li>
                {% for item in page %}
                <li class="paginate_button {{ item.active }}" tabindex="0">
                    <a href="#">{{ item.number }}</a>
                </li>
                {% endfor %}
                <li class="paginate_button next {{ resume.next }}" tabindex="0">
                    <a href="#">{{ lang('admin.next') }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
