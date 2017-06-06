{include file='parts/header.tpl'}
<h1>Hello, {$user.name}</h1>
<p>ID: {$user.id}</p>
<p>Description: {$user.description}</p>
<p>Email: {$user.email}</p>
<p>created: {$user.created|date_format:'%Y-%m-%d %H:%M:%S'}</p>
{include file='parts/footer.tpl'}
