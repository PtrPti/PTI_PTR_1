## Fazer isto antes de começar a corrigir alguma coisa nos vossos pcs

- Apaguem a pasta do projeto que têm agora, ou se não quiserem apagar, mudem o nome da pasta para uma coisa diferente de "PTR_PTI_1"
- Façam clone do projeto para um sitio qualquer (pode ser onde tinham o projeto antigo). Abram o terminal (cmd) na pasta onde vai ficar o projeto tipo no C:\ ou C:\projeto e façam: git clone https://github.com/PtrPti/PTI_PTR_1.git
- Abram o terminal (cmd) na pasta do projeto (a pasta do projeto deverá ser PTR_PTI_1) e façam o comando: composer update
Esperar que execute e deverá aparecer uma imagem pareceida com isto (em principio o vosso vai ser com menos coisas)
![Image of Yaktocat](https://i.imgur.com/uVw1LCH.png)
- Para ser mais fácil de trabalhar nas cenas e de não haver tanta confusão, criem um branch novo no projeto. Eu já criei o meu
![Image of Yaktocat](https://i.imgur.com/NcOvmfX.png)
- Dentro da pasta do projeto façam: git checkout -b [name_of_your_new_branch] --------- acho que é mais facil se cada um der o seu nome ao branch para saber de quem são as cenas
Aqui o branch só foi criado ainda no vosso pc
- Fazer: git push origin [name_of_your_new_branch]
Aqui estão a fazer push do vosso branch para o git. Se forem ao git e clicarem naquele menu que stá na segunda imagem, deverá aparecer o vosso branch. Se clicarem no vosso branch, aparecem os ficheiros que estão lá (neste caso vai ser igual ao branch master)
- Dentro da pasta do projeto se fizerem: git branch, vai aparecer uma lista com todos os branches e um deles vai ter um "\*" no início. Esse "\*" diz qual é o branch onde vocês estão a trabalhar.
- Façam: git checkout [name_of_your_new_branch], para mudarem para o vosso branch. (Se fizerem: git branch, o '\*' está no vosso branch agora).
- A partir de agora estão a trabalhar no vosso branch e todas alterações são feitas só na vossa ceninha e não mexem com o branch principal. Podem fazer commits e pushes à vontade que vai ser só no vosso branch e não mexe com o trabalho de ninguém (:
- Se não tiverem a certeza se estão no branch certo, façam os comandos em cima para ver.


- Eu sei que isto pode ser demais, mas vai evitar confusões nas coisas todas e até é mais fácil se alguém precisar de ajudar alguém ou se for preciso ir buscar cenas de outros.

Qualquer coisa chateiem :D
