{% extends config_backend %}

{% block title %} {% endblock %}

{% block head %}  

<style>

</style>
{% endblock %}

{% block heading %} {% endblock %}

{% block content %}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="pull-left"></h2>
                <div class="pull-right">
                    <div class="table-buttons">
                        <a data-action="/%$appurl%/%$nameurl%/new" data-id="" class="btn-new btn btn-xs btn-default ">
                            <span class="glyphicon glyphicon-plus"></span> {{ lang('admin.insert') }}</a>
                        <a href="/%$appurl%/%$nameurl%/export" class="btn btn-xs btn-default">
                            <span class="glyphicon glyphicon-export"></span> {{ lang('admin.export') }}</a>
                        <a data-action="/%$appurl%/%$nameurl%/filter" class="btn-showfilter btn btn-xs btn-primary">                            
                            <span class="glyphicon glyphicon-filter"></span> {{ lang('admin.filter') }}</a>
                        <div class="table-filters" style="display: none">{% include '%$viewName%/filter.html' %}</div>
                    </div>
                </div>
                <br />
            </div>
            <div class="panel-body">
                {% include '%$viewName%/table.html' %}
            </div>
            <div class="panel-footer">
                
            </div>
        </div>
    </div>
</div>

<div id="mainModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

{% endblock %}

{% block footer %} {% endblock %}

{% block scripts %} 

<script>
$(document).ready(function () {
    
});

</script>
{% endblock %}

