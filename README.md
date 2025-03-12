# Configuração do Ambiente de Desenvolvimento Local

Este projeto requer a configuração de um Virtual Host e a modificação do arquivo `hosts` para funcionar corretamente no ambiente de desenvolvimento local.

## Configuração do Virtual Host (XAMPP)

1.  Abra o arquivo `C:\xampp\apache\conf\extra\httpd-vhosts.conf` como administrador.
2.  Adicione o seguinte bloco de código ao final do arquivo:

```apache
<VirtualHost *:80>
    DocumentRoot "C:\xampp\htdocs\biblioteca"  # Substitua pelo caminho correto do seu projeto
    ServerName biblioteca.local                # Substitua pelo nome de domínio desejado
    <Directory "C:\xampp\htdocs\biblioteca">  # Substitua pelo caminho correto do seu projeto
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
