{include file='parts/header.tpl'}
<h1>{$hello} {$user.name}</h1>
<p>ID: {$user.id}</p>
<p>Description: {$user.description}</p>
<p>Email: {$user.email}</p>
<p>created: {$user.created|date_format:'r'}</p>
{include file='parts/footer.tpl'}
