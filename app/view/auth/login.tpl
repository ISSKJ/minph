{include file='parts/header.tpl'}

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form method="post" action="/login">
            <div class="form-group {if $error.inputEmail}has-error{/if}">
                <label for="inputEmail">Email address</label>
                <input type="email" value="{$data.inputEmail}" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email address">
                <p class="control-label">{$error.inputEmail}</p>
            </div>
            <div class="form-group {if $error.inputPassword}has-error{/if}">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
                <p class="control-label">{$error.inputPassword}</p>
            </div>
            <button type="submit" class="btn btn-default">Login</button>
        </form>
    </div>
</div>

{include file='parts/footer.tpl'}
