 @extends('admin.layouts.control')

@section('content')

<section class="website page">

@if (isset($website)) 
  {!! Form::model($website, ['method' => 'post', 'id' => 'websites-form']) !!}
@endif

  <div class="actionbar">
    <div class="header"><h3>Edit Website</h3></div>
    <div class="button">
      <span class="btn-group pull-right">
        <button type="button" class="btn btn-success btn-sm" id="save"><i class="fa fa-save"></i> Save</button>
        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-caret-down"></i>
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#" id="save-translating">Translating</a></li>
          <li><a href="#" id="save-enable">Enable</a></li>
          <li><a href="#" id="save-disable">Disable</a></li>
          <li><a href="#" id="save-discard">Discard changes</a></li>
        </ul>
      </span>
      <span class="status pull-right">
        {!! Form::hidden('web_status', null, ['id' => 'web_status']) !!}
        <button class="btn btn-{{ $websiteStatusColours[$website->web_status] }} btn-sm" disabled>{{ $websiteStatusNames[$website->web_status] }}</button>
      </span>
    </div>
  </div>
  <div>
    <div class="block-flex">
      <div class="block-6 form-horizontal">
        <div class="form-group">
          <label class="col-sm-3 control-label" for="web_title">Title</label>
          <div class="col-sm-9">
            {!! Form::text('web_title', null, ['id' => 'web_title', 'class' => 'form-control']) !!}
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="web_main_domain">Domain</label>
          <div class="col-sm-9">
            {!! Form::text('web_main_domain', null, ['id' => 'web_main_domain', 'class' => 'form-control']) !!}
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="web_lang">Language</label>
          <div class="col-sm-9">
            <div class="input-group">
              {!! Form::text('web_lang', null, ['id' => 'web_lang', 'class' => 'form-control']) !!}
              <span class="input-group-addon tip" title="Default Language">
                {!! Form::checkbox('web_lang_default', true, null, ['id' => 'web_lang_default']) !!}
              </span>
            </div>
          </div>
        </div>  
        <div class="form-group">
          <label class="col-sm-3 control-label" for="web_cou_id">Country</label>
          <div class="col-sm-9">
            {!! Form::select('web_cou_id', $countries, null, ['id' => 'web_cou_id', 'class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      <div class="block-6 form-horizontal">
        <div class="form-group">
          <label class="col-sm-3 control-label">Tokens</label>
          <div class="col-sm-9">
            <div class="progress">
              <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="width: {{ percCalc($website->tokens->count(), $baseTokensCount) }}%">
                <span class="tip" title="Translated">{{ $website->tokens->count() }} / {{ $baseTokensCount }} {{ percCalc($website->tokens->count(), $baseTokensCount) }}% Translated</span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Tags</label>
          <div class="col-sm-9">
            <div class="progress">
              <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="width: {{ percCalc($website->tags->count(), $baseTagsCount) }}%">
                <span class="tip" title="Translated">{{ $website->tags->count() }} / {{ $baseTagsCount }} {{ percCalc($website->tags->count(), $baseTagsCount) }}% Translated</span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Links</label>
          <div class="col-sm-9">
            <div class="progress">
              <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="width: {{ percCalc($website->links->count(), $baseLinksCount) }}%">
                <span class="tip" title="Translated">{{ $website->links->count() }} / {{ $baseLinksCount }} {{ percCalc($website->links->count(), $baseLinksCount) }}% Translated</span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label">Industries</label>
          <div class="col-sm-9">
            <div class="progress">
              <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="width: {{ percCalc($website->industries->count(), $baseIndustriesCount) }}%">
                <span class="tip" title="Translated">{{ $website->industries->count() }} / {{ $baseIndustriesCount }} {{ percCalc($website->industries->count(), $baseIndustriesCount) }}% Translated</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row-full">
      <div class="block">
        <ul class="nav nav-tabs" id="myTab">
          <li class="active"><a data-target="#welcome" data-toggle="tab">Welcome</a></li>
          <li><a data-target="#permission" data-toggle="tab">Permissions</a></li>
          <li><a data-target="#clients" data-toggle="tab">Clients</a></li>
          <li><a data-target="#store" data-toggle="tab">Store</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="welcome">Coming soon</div>
          <div class="tab-pane" id="permission">Coming soon</div>
          <div class="tab-pane" id="clients">Coming soon</div>
          <div class="tab-pane" id="store">Coming soon</div>
        </div>
      </div>
    </div>
  </div>

{{ Form::close() }}

</section>

{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.4/js/bootstrap-select.min.js') !!}

<script>
$(function() {

    $('input[type="checkbox"]').bootstrapToggle({
        size: 'mini',
        on: '<i class="fa fa-check"></i>',
        off: '<i class="fa fa-times"></i>',
        onstyle: "success",
        offstyle: "default",
    });
    $('.page')  
    .on('click', '#save-translating', function() {
      $('#web_status').val('{{ websiteStatus('translating') }}');
      $('#websites-form').submit();
    })
    .on('click', '#save-enable', function() {
      $('#web_status').val('{{ websiteStatus('enable') }}');
      $('#websites-form').submit();
    })
    .on('click', '#save-disable', function () {
      $('#web_status').val('{{ websiteStatus('disable') }}');
      $('#websites-form').submit();
    })
    .on('click', '#save-discard', function() {
      if (! confirm('Are you sure?')) return false;
      location.href='/admin/websites';
    });

    $('select').selectpicker({size: 10});
});
</script>

@stop








