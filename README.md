## adicli
Adianti CLI (Command Line Interface)

<img src="https://raw.githubusercontent.com/marcelonees/adicli/master/usr/share/adicli/images/screenshot.gif" alt="Screenshot">

A intenção de criar esta ferramenta de linha de comando não é substituir o [Adianti Studio](https://www.adianti.com.br/studio), que é uma ferramenta incrível e que aumenta em muito a produtividade, desenvolvido por [Pablo Dall'oglio](https://dalloglio.net).

Ocorre que o Adianti Studio foi descontinuado, em favor do novo [Adianti Builder](https://www.adiantibuilder.com.br).

Dessa forma, o adicli pretende ser uma interface rápida para criação de telas baseadas em templates, que podem ser customizados para atender necessidades específicas do desenvolvedor.

Os templates inclusos no adicli são os mesmos disponíveis no [Sourceforge](https://sourceforge.net/projects/adianti/) do Adianti.

Segundo o [site](https://www.adianti.com.br) do Framework Adianti:

>A missão da Adianti é aumentar a produtividade de sua comunidade.
Queremos ser vistos como os melhores parceiros de TI para o seu negócio.

## Sistemas Operacionais (testados):
- Debian Gnu/Linux 11 (bullseye)

## Suporte aos seguintes bancos de dados:
- PostgreSQL (psql)
- MySQL (mysql)
- MariaDB (mysql)
- Firebird (isql-fb)

---

## 🚀 Como instalar
Logado como usuário root, faça:
```
git clone https://github.com/marcelonees/adicli.git
cd adicli
sudo ./install.sh
```

---

## ☕ Como usar

O adicli é intuitivo, basta passar os parâmetros solicitados e ele irá gerar o arquivo php.

```bash
adicli -c database.conf \
       -A "Full Name <your_email@domain" \
       -t Table \
       -M Model \
       -T Template \
       -C ClassName \ 
       -O [tables|templates|examples]
```

---

## Exemplos de uso

Veja outros exemplos de uso à seguir.

---

### Criar o Model de Customers

```bash
adicli -c /etc/adicli/databases/mysql.conf  \
       -A "Full Name <your_email@domain" \
       -t customers \
       -M Customers \
       -T /usr/share/adicli/framework/templates/model/Model.php \
       -C Customers > Customers.class.php
```

---

### Criar um formulário de Customers

```bash
adicli -c /etc/adicli/databases/mysql.conf  \
       -A "Full Name <your_email@domain" \
       -t customers \
       -M Customers \
       -T /usr/share/adicli/framework/templates/form/StandardForm.php \
       -C CustomersForm > CustomersForm.class.php
```

---

### Criar uma listagem de Customers

```bash
adicli -c /etc/adicli/databases/mysql.conf  \
       -A "Full Name <your_email@domain" \
       -t customers \
       -M Customers \
       -T /usr/share/adicli/framework/templates/list/StandardList.php \
       -C CustomersList > CustomersList.class.php
```

---

### Listando as tabelas de um banco de dados

```bash
adicli -c database.conf -O tables
```

---

### Listando as templates disponíveis

```bash
adicli -O templates
```

---

### Listando alguns exemplos de uso

```bash
adicli -O examples
```

---

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
- [x] ##FORM_FIELD[0]##
- [x] ##FORM_FIELD[1]##
- [x] ##FORM_FIELD[2]##
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

---

## 📫 Contribuindo
<!---Se o seu README for longo ou se você tiver algum processo ou etapas específicas que deseja que os contribuidores sigam, considere a criação de um arquivo CONTRIBUTING.md separado--->
Para contribuir com adicli, siga estas etapas:

1. Faça um fork deste repositório.
2. Crie um branch: `git checkout -b <nome_branch>`.
3. Faça suas alterações e confirme-as: `git commit -m '<mensagem_commit>'`
4. Envie para o branch original: `git push origin <nome_do_projeto> / <local>`
5. Crie a solicitação de pull.

Como alternativa, consulte a documentação do GitHub em [como criar uma solicitação pull](https://help.github.com/en/github/collaborating-with-issues-and-pull-requests/creating-a-pull-request).


---

## 🤝 Colaboradores 

Agradecemos às seguintes pessoas que contribuíram para este projeto:

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/marcelonees">
        <img src="https://avatars3.githubusercontent.com/u/923628?s=100" width="100px;" alt="Marcelo Barreto Nees"/><br>
        <sub>
          <b>Marcelo Barreto Nees</b>
        </sub>
      </a>
    </td>
  </tr>
</table>


---

## 😄 Seja um dos contribuidores<br>

Quer fazer parte desse projeto? Clique [AQUI](CONTRIBUTING.md) e leia como contribuir.

---

## 📝 Licença

Esse projeto está sob licença. Veja o arquivo [LICENÇA](LICENSE.md) para mais detalhes.
[⬆ Voltar ao topo](#adicli)<br>
