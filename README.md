# adicli
Adianti CLI (Command Line Interface)


![GitHub repo size](https://img.shields.io/github/repo-size/marcelonees/README-template?style=for-the-badge)
![GitHub language count](https://img.shields.io/github/languages/count/marcelonees/README-template?style=for-the-badge)
![GitHub forks](https://img.shields.io/github/forks/marcelonees/README-template?style=for-the-badge)

A intenção de criar esta ferramenta de linha de comando não é substituir o Adianti Studio, 
que é uma ferramenta incrível e que aumenta em muito a produtividade.

Ocorre que esta ferramenta foi descontinuada, em favor do novo Adianti Builder [https://www.adiantibuilder.com.br/].

Dessa forma, o adicli pretende ser uma interface rápida para criação de telas baseadas em templates, que podem ser customizados
para atender necessidades específicas do desenvolvedor.

Segundo o site do Desenvolvedor do Adianti (Pablo Dall'oglio):

A missão da Adianti é aumentar a produtividade de sua comunidade.
Queremos ser vistos como os melhores parceiros de TI para o seu negócio.

Mais informações sobre o Framework:
[https://www.adianti.com.br/]


## Sistemas Operacionais (testados):
- Debian Gnu/Linux 11 (bullseye)

## Suporte aos seguintes bancos de dados:
- PostgreSQL (psql)
- MySQL (mysql)
- MariaDB (mysql)
- Firebird (isql-fb)

## 🚀 Como instalar
Logado como usuário root, faça:
```
git clone https://github.com/marcelonees/adicli.git
./install.sh
```

## ☕ Como usar
```
user@host:~$ adicli -c /etc/adicli/databases/database.conf -t Customers -T /usr/share/adicli/framework/templates/form/StandardForm.php -C CustomersForm"
```
### Ajustes e melhorias

O projeto ainda está em desenvolvimento e as próximas atualizações serão voltadas para substituir as seguintes MÁSCARAS dentro das templates:

- [ ] ##DATA##
- [ ] ##DETAIL_FIELD[0]##
- [ ] ##DETAIL_FIELD[1]##
- [ ] ##DETAIL_FIELD[2]##
- [ ] ##DETAIL_FIELD[3]##
- [ ] ##DETAIL_FIELD[4]##
- [ ] ##DETAIL_FIELD[5]##
- [ ] ##DETAIL_FIELD[7]##
- [ ] ##DETAIL_FIELD[8]##
- [x] ##FILTER_FIELDS##
- [ ] ##FILTERS##
- [ ] ##FILTER_SEARCHS##
- [ ] ##FORM_FIELD[0]##
- [ ] ##FORM_FIELD[1]##
- [ ] ##FORM_FIELD[2]##
- [ ] ##FORM_FIELD[3]##
- [ ] ##FORM_FIELD[4]##
- [ ] ##FORM_FIELD[5]##
- [ ] ##FORM_FIELD[6]##
- [x] ##FORM_FIELDS##
- [ ] ##FORM_SETUP##
- [ ] ##INIT_METHODS##
- [x] ##LIST_COLUMNS##
- [ ] ##MASTER_FIELD[0]##
- [ ] ##MASTER_FIELD[1]##
- [ ] ##MASTER_FIELD[2]##
- [ ] ##METHODS##
- [ ] ##QUERY_FIELD[0]##
- [ ] ##QUERY_FIELD[1]##
- [ ] ##QUERY_FILTER[0]##
- [ ] ##QUERY_FILTER[1]##
- [ ] ##QUERY_FILTER[2]##
- [ ] ##QUERY_FILTER[3]##
- [ ] ##RESULT_FIELDS##
- [ ] ##SESSION_FILTERS##
- [ ] ##STYLES##
- [ ] ##TITLES##

## 😄 Seja um dos contribuidores<br>

Quer fazer parte desse projeto? Clique [AQUI](CONTRIBUTING.md) e leia como contribuir.

## 📝 Licença

Esse projeto está sob licença. Veja o arquivo [LICENÇA](LICENSE.md) para mais detalhes.
[⬆ Voltar ao topo](#adicli)<br>