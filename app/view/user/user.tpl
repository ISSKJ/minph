{include file='parts/header.tpl'}
<div class="col-md-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2>Hello, {$user.name}</h2>
        </div>
        <div class="panel-body">
            <p>Email: {$user.email}</p>
        </div>
    </div>
</div>
{include file='parts/footer.tpl'}
