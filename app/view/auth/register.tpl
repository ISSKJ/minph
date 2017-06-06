{include file='parts/header.tpl'}

<div class="row">
    <div class="col-md-4 col-md-offset-3 panel padding32">
        <form method="post" action="/confirmRegister">
            <div class="form-group {if $error.inputFirstName}has-error{/if}">
                <label for="inputFirstName">First name</label>
                <input type="text" value="{$data.inputFirstName}" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="First name">
                <p class="control-label">{$error.inputFirstName}</p>
            </div>
            <div class="form-group {if $error.inputLastName}has-error{/if}">
                <label for="inputLastName">Last name</label>
                <input type="text" value="{$data.inputLastName}" class="form-control" id="inputLastName" name="inputLastName" placeholder="Last name">
                <p class="control-label">{$error.inputLastName}</p>
            </div>
            <div class="form-group {if $error.inputEmail}has-error{/if}">
                <label for="inputEmail">Email address</label>
                <input type="email" value="{$data.inputEmail}" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email address">
                <p class="control-label">{$error.inputEmail}</p>
            </div>
            <div class="form-group {if $error.inputPassword}has-error{/if}">
                <label for="inputPassword">Password</label>
                <input type="password" value="{$data.inputPassword}" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
                <p class="control-label">{$error.inputPassword}</p>
            </div>
            <div class="form-group {if $error.inputConfirmPassword}has-error{/if}">
                <label for="inputConfirmPassword">Confirm password</label>
                <input type="password" class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" placeholder="Password">
                <p class="control-label">{$error.inputConfirmPassword}</p>
            </div>
            <p class="bg-danger">{$error.error}</p>
            <button type="submit" class="btn btn-default">Signup</button>
        </form>
    </div>
</div>

{include file='parts/footer.tpl'}
