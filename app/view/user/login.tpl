{include file='parts/header.tpl'}
<br/>
<br/>
<div class="col-md-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h1 class="panel-title">Login</h1>
        </div>
        <div class="panel-body">
            <form action="/login" method="POST">
                <div class="form-group {if $errors.email}has-error{/if}">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" placeholder="test@example.com" value="{$data.email}">
                    <label class="control-label">{$errors.email}</label>
                </div>
                <div class="form-group {if $errors.password}has-error{/if}">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password" placeholder="password (should contain special characters)">
                    <label class="control-label">{$errors.password}</label>
                </div>
                {if $errors.auth}
                <div class="form-group has-error">
                    <label class="control-label">{$errors.auth}</label>
                </div>
                {/if}
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>

{include file='parts/footer.tpl'}
