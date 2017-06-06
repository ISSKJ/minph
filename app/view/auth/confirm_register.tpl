{include file='parts/header.tpl'}

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form method="post" action="/register">
            <div class="form-group">
                <label for="inputFirstName">First name</label>
                <input type="text" value="{$data.inputFirstName}" class="form-control" id="inputFirstName" name="inputFirstName" readonly="readonly" placeholder="First name">
            </div>
            <div class="form-group">
                <label for="inputLastName">Last name</label>
                <input type="text" value="{$data.inputLastName}" class="form-control" id="inputLastName" name="inputLastName" readonly="readonly" placeholder="Last name">
            </div>
            <div class="form-group">
                <label for="inputEmail">Email address</label>
                <input type="email" value="{$data.inputEmail}" class="form-control" id="inputEmail" name="inputEmail" readonly="readonly" placeholder="Email address">
            </div>
            <input type="hidden" name="encodedPassword" value="{$data.encodedPassword}">
            <button type="submit" class="btn btn-default">Confirm</button>
        </form>
    </div>
</div>

{include file='parts/footer.tpl'}
