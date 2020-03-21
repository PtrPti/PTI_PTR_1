<div id="projetos">
    <div class="split left">
            <div class="centered">  
                <button id='button' class="btn" onclick="$('.bg-modal').slideToggle(function(){ $('#button').html($('.bg-modal').is(':visible')?'See Less Details':'See More Details');});"> Criar Novo Projeto</button>
            </div>
        </div>

        <div class="split right">
            <div class="centered">
                <p> Projetos <p>
            </div>
        </div>


    <div class="bg-modal">
        <div class="model-content">
            <div class="close" onclick="closeForm()" >x</div>
            <h4>Novo Projeto</h4>
            
            <form action="" enctype="multipart/form-data" method="post">
                <input type="text" placeholder="Nome do Projeto">
                <input type="text" placeholder="Disciplina">
                <input type="file" name="adicionar ficheiro">
                    
                <input type="date" name="Data de Fim">

                <a href=""  >Adicionar</a>
            </form>
        </div>
    </div> 
</div>
