# Duosystem

Projeto para teste de conhecimento.

###Como instalar

Verifique se possui o [virtualbox](https://www.virtualbox.org/wiki/Downloads) e o [vagrant](https://www.vagrantup.com/) instalado na sua maquina
e execute a linha de comando a seguir no terminal dentro do diretório do projeto:

    $ vagrant up
    
Enquanto o script de instalação do servidor é executado abra o arquivo hosts no seu
editor favorito com permissão root/administrador.

####LINUX / MAC

    $ /etc/hosts
    
####WINDOWS

    C:\Windows\System32\Drivers\etc\hosts
    
Adicione uma nova linha  ```172.28.128.6  duosystem.test```

Quando terminar de rodar o script do vagrant acesse no seu navegador [duosystem.test](http://duosystem.test)


####Caso ocorra algum problema com sua VM por favor entre em contato [comigo através do e-mail brunokoga187@gmail.com](mailto:brunokoga187@gmail.com)

Caso precise acessar a VM digite ```$ vagrant ssh``` dentro do diretório do projeto senha: ```vagrant```

    