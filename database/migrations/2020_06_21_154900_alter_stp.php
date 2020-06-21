<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            'DROP PROCEDURE IF EXISTS GetTarefas;

            
            CREATE PROCEDURE GetTarefas (
                IN grupoId INT,
                IN estadoT bool,
                IN search nvarchar(50)
            )
            BEGIN    
                DROP TEMPORARY TABLE IF EXISTS tarefasPai;
                DROP TEMPORARY TABLE IF EXISTS tarefasFilho;

                CREATE TEMPORARY TABLE IF NOT EXISTS tarefasPai AS (
                    SELECT id 
                    FROM tarefas 
                    where grupo_id = grupoId and estado = estadoT and tarefa_id is null
                );
                
                CREATE TEMPORARY TABLE IF NOT EXISTS tarefasFilho AS (
                    SELECT t.*
                    FROM tarefas t
                    inner join tarefasPai pai
                    on t.id = pai.id or t.tarefa_id = pai.id
                );
                
                select tf.*, u.nome as atribuido
                from tarefasFilho tf
                left join users u
                    on tf.user_id = u.id
                where CASE WHEN search IS null THEN tf.nome is not null or u.nome is not null ELSE tf.nome like CONCAT("%", search, "%") or u.nome like CONCAT("%", search, "%") END
                order by CASE WHEN tarefa_id IS null THEN tf.id ELSE tarefa_id END ASC,
                CASE WHEN tarefa_id IS null THEN null ELSE tf.id END ASC, ordem;
            
            END;'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
