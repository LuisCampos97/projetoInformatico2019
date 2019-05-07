<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); //ou NIF ou BI (9 numeros em caso de CC)
            //Parecer e anexo
            $table->string('numero_identificacao')->nullable();
            $table->enum('tipo_documento', ['cartao_cidadao', 'passaporte'])->nullable();
            $table->string('name');
            $table->string('username')->unique()->nullable();
            // $table->enum('role', ['proponente', 'diretor_uo', 'ctc', 'secretariado_direcao', 'recursos_humanos'])->nullable();
            $table->string('role');
            $table->string('password');
            $table->string('email')->unique();
            $table->boolean('blocked')->default(false);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('departamento', function (Blueprint $table){
            $table->increments('id');
            $table->string('nome_departamento');
            $table->string('sigla');
            $table->integer('coordenador_departamento')->unsigned();
            $table->foreign('coordenador_departamento')->references('id')->on('users');
        });

        Schema::create('curso', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome_curso');
            $table->string('sigla');
            $table->integer('departamento_id')->unsigned();
            $table->foreign('departamento_id')->references('id')->on('departamento');
        });

        Schema::create('unidade_curricular', function (Blueprint $table){
            $table->increments('id');
            $table->string('nome');
            $table->integer('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('curso');
            $table->integer('departamento_id')->unsigned();
            $table->foreign('departamento_id')->references('id')->on('departamento');
            $table->enum('regime', ['Diurno', 'Pos-Laboral']);
            $table->enum('tipo', ['Semestral', 'Anual']);
            $table->string('turno');
        });

        Schema::create('proposta_proponente', function(Blueprint $table){
            $table->increments('id');
            $table->enum('unidade_organica', ['ESECS', 'ESTG', 'ESAD.CR', 'ESTM', 'ESSLei']);
            $table->string('nome_completo');
            $table->dateTime('data_de_assinatura_coordenador_departamento')->nullable();
            $table->dateTime('data_de_assinatura_coordenador_de_curso')->nullable();
            $table->enum('tipo_contrato', ['Contratação Inicial', 'Renovação', 'Visitante']);
            $table->enum('grau', ['Doutoramento', 'Pos-Graduacao', 'Licenciatura', 'Ensino Secundario', 'Mestrado']);
            $table->string('curso');
            $table->string('area_cientifica');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_proponente_professor', function (Blueprint $table){
            $table->increments('id');
            $table->enum('role_professor', ['Coordenador', 'Adjunto', 'Visitante']);
            $table->enum('regime_prestacao_servicos', ['Tempo Parcial', 'Tempo Integral', 'Dedicação exclusiva']);
            $table->integer('percentagem_prestacao_servicos')->nullable(); //em caso de tempo parcial??
            $table->string('periodo');
            $table->string('duracao');
            $table->enum('avaliacao_periodo_anterior', ['Positiva', 'Negativa'])->nullable();
            //Signature???
            $table->integer('proposta_proponente_id')->unsigned();
            $table->foreign('proposta_proponente_id')->references('id')->on('proposta_proponente');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            //$table->enum('type', ['pdf', 'png', 'jpeg']);
            $table->string('original_name');
            $table->string('description')->nullable();
            $table->integer('proposta_id')->unsigned();
            $table->foreign('proposta_id')->references('proposta')->on('id');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('proposta_proponente_assistente', function(Blueprint $table){
            $table->increments('id');
            $table->enum('regime_prestacao_servicos', ['Tempo Parcial', 'Tempo Integral', 'Dedicação exclusiva']);
            $table->integer('percentagem_prestacao_servicos')->nullable();
            $table->string('periodo');
            $table->string('duracao');
            $table->enum('avaliacao_periodo_anterior', ['Positiva', 'Negativa']);
            $table->integer('proposta_proponente_id')->unsigned();
            $table->foreign('proposta_proponente_id')->references('id')->on('proposta_proponente');
            //Signature???
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_proponente_monitor', function (Blueprint $table){
            $table->increments('id');
            $table->enum('regime_prestacao_servicos', ['Tempo Parcial']);
            $table->integer('percentagem_prestacao_servicos');
            $table->string('periodo');
            $table->string('duracao');
            $table->integer('proposta_proponente_id')->unsigned();
            $table->foreign('proposta_proponente_id')->references('id')->on('proposta_proponente');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ucs_proposta_proponente', function(Blueprint $table){
            $table->increments('id');
            $table->string('nome_unidade_curricular');
            $table->enum('regime', ['Diurno', 'Pos-Laboral']);
            $table->enum('tipo', ['Semestral', 'Anual']);
            $table->integer('horas')->unsigned();
            $table->integer('horas_semestrais')->unsigned();
            $table->integer('departamento_id')->unsigned();
            $table->foreign('departamento_id')->references('id')->on('departamento');
            $table->integer('proposta_proponente_id')->unsigned();
            $table->foreign('proposta_proponente_id')->references('id')->on('proposta_proponente');
            $table->string("turno");
        });

        Schema::create('proposta_diretor_uo', function(Blueprint $table){
            $table->increments('id');
            $table->boolean('reconhecimento')->default(false);
            $table->enum('parecer', ['Favoravel', 'Desfavoravel']);
            //Signature??
            $table->dateTime('data_assinatura');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_ctc', function(Blueprint $table){
            $table->increments('id');
            $table->integer('votos_a_favor')->default(0);
            $table->integer('votos_contra')->default(0);
            $table->integer('votos_brancos')->default(0);
            $table->integer('votos_nulos')->default(0);
            $table->enum('aprovacao', ['Aprovado', 'Nao Aprovado']);
            //Signature??
            $table->dateTime('data_assinatura');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_secretariado_direcao', function(Blueprint $table){
            $table->increments('id');
            $table->string('convite');
            $table->softDeletes();
            $table->timestamps();
            ///WHAT ELSE???
        });

        Schema::create('proposta_recursos_humanos', function (Blueprint $table){
            $table->increments('id');
            $table->decimal('remuneracao', 6, 2);
            $table->string('escalao');
            $table->string('indice');
            $table->integer('numero_funcionario')->unsigned();
            $table->boolean('contratacao_comunicada')->default(false);
            $table->boolean('inscricao_seguranca_social')->default(false);
            $table->boolean('inscricao_caiga_geral_aposentacoes')->default(false);
            $table->datetime('despacho_presidente_ipl');
            $table->boolean('contrato_redigido')->default(false);
            $table->boolean('contrato_anexo')->default(false);
            $table->boolean('cessacao_social')->default(false);
            $table->integer('NISS_ou_numero_CGA')->unsigned();
            $table->datetime('data_nascimento');
            $table->integer('numero_CC')->unsigned();
            $table->string('email')->unique();
            $table->string('dados_GIAF_carregados_por');
            $table->datetime('data_carregamento_dados_GIAF');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposta_proponente_id')->unsigned()->nullable();
            $table->foreign('proposta_proponente_id')->references('id')->on('proposta_proponente');
            $table->integer('proposta_diretor_uo_id')->unsigned()->nullable();
            $table->foreign('proposta_diretor_uo_id')->references('id')->on('proposta_diretor_uo');
            $table->integer('proposta_ctc_id')->unsigned()->nullable();
            $table->foreign('proposta_ctc_id')->references('id')->on('proposta_ctc');
            $table->integer('proposta_secretariado_direcao_id')->unsigned()->nullable();
            $table->foreign('proposta_secretariado_direcao_id')->references('id')->on('proposta_secretariado_direcao');
            $table->integer('proposta_recursos_humanos_id')->unsigned()->nullable();
            $table->foreign('proposta_recursos_humanos_id')->references('id')->on('proposta_recursos_humanos');
            $table->enum('status', ['pendente', 'recusada', 'finalizada']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposta');
        Schema::dropIfExists('ucs_proposta_proponente');
        Schema::dropIfExists('proposta_proponente');
        Schema::dropIfExists('proposta_proponente_professor');
        Schema::dropIfExists('proposta_proponente_assistente');
        Schema::dropIfExists('proposta_proponente_monitor');
        Schema::dropIfExists('curso');
        Schema::dropIfExists('departamento');
        Schema::dropIfExists('proposta_diretor_uo');
        Schema::dropIfExists('proposta_ctc');
        Schema::dropIfExists('proposta_secretariado_direcao');
        Schema::dropIfExists('proposta_recursos_humanos');
        Schema::dropIfExists('unidade_curricular');
        Schema::dropIfExists('users');
    }
}
