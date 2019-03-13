
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/d510a56b93ad44109e89853298c299b8)](https://app.codacy.com/app/Mya555/API-Projet-7?utm_source=github.com&utm_medium=referral&utm_content=Mya555/API-Projet-7&utm_campaign=Badge_Grade_Dashboard)

<h1>BileMo-Projet-7</h1>
<p>The project is created for the curcus of OpenClassrooms.</p>
<p>The project must be created about the development of the website for selling BileMo company's products with using API REST.
</p>
<p>Developed with API REST.</p>
<h1>How to install the project</h1>
<h4>1 - Download or clone the repository git</h4>
<pre><code>https://github.com/Mya555/API-Projet-7.git</pre></code>

<h4>2 - Download dependencies :</h4>
<pre><code>composer install</pre></code> 

<h4>3 - Configure the database  :</h4>
<pre><code>In .env configure database and mailer</pre></code> 

<h4>4 - Generate the SSH keys with JWT passphrase  and add JWT keys path in .env :</h4>
<pre><code>$ mkdir var/jwt
$ openssl genrsa -out var/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem 
</pre></code> 

<h4>5 - Create database :</h4>
<pre><code>php bin/console doctrine:database:create</pre></code>

<h4>6 - Create schema :</h4>
<pre><code>php bin/console doctrine:schema:update --force</pre></code>

<h4>7 - Load fixtures :</h4>
<pre><code>php bin/console doctrine:fixtures:load</pre></code>

<h4>8 - Run the server :</h4>
<pre><code>PHP -S localhost:8080</pre></code>

<h4>9 - Documentation :</h4>
<pre><code>{your_domain}/api/doc</pre></code>
<h1>Existing users</h1>
<table>
<thead>
  <tr>
  <th>login</th>
  <th>password</th>
  </tr>
</thead>
