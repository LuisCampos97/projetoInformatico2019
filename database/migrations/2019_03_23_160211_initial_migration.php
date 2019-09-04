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
            $table->enum('roleDB', ['proponente_departamento', 'proponente_curso', 'diretor_uo', 'ctc', 'secretariado_direcao', 'recursos_humanos', 'docente_temp', 'admin'])->nullable();
            $table->string('role');
            $table->string('unidade_organica');
            $table->string('password');
            $table->string('email');
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
            $table->increments('codigo');
            $table->string('nome_curso');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('unidade_curricular', function (Blueprint $table){
            $table->increments('codigo');
            $table->string('nome');
            $table->integer('codigo_curso')->unsigned();    
            $table->foreign('codigo_curso')->references('codigo')->on('curso');
            $table->integer('departamento_id')->unsigned()->nullable();
            $table->foreign('departamento_id')->references('id')->on('departamento');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_proponente', function(Blueprint $table){
            $table->increments('id_proposta_proponente');
            $table->enum('unidade_organica', ['ESECS', 'ESTG', 'ESAD.CR', 'ESTM', 'ESSLei']);
            $table->string('nome_completo');
            $table->string('email');
            $table->string('numero_telefone');
            $table->dateTime('data_de_assinatura_coordenador_departamento')->nullable();
            $table->dateTime('data_de_assinatura_coordenador_de_curso')->nullable();
            $table->enum('tipo_contrato', ['contratacao_inicial', 'renovacao', 'alteracao']);
            $table->string('grau');
            $table->string('curso');
            $table->string('area_cientifica');
            $table->string('fundamentacao_coordenador_curso')->nullable();
            $table->string('fundamentacao_coordenador_departamento')->nullable();
            $table->string('primeiro_proponente');
            $table->string('segundo_proponente')->nullable();
            $table->enum('role', ['professor', 'assistente', 'monitor']);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_proponente_professor', function (Blueprint $table){
            $table->increments('id_proposta_proponente_professor');
            $table->enum('role_professor', ['coordenador', 'adjunto', 'visitante']);
            $table->enum('regime_prestacao_servicos', ['tempo_parcial', 'tempo_integral', 'dedicacao_exclusiva']);
            $table->integer('percentagem_prestacao_servicos')->nullable();
            $table->string('fundamentacao')->nullable();
            $table->string('periodo');
            $table->string('duracao');
            $table->enum('avaliacao_periodo_anterior', ['positiva', 'negativa'])->nullable();
            //Signature???
            $table->integer('proposta_proponente_id')->unsigned();
            $table->foreign('proposta_proponente_id')->references('id_proposta_proponente')->on('proposta_proponente');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_proponente_assistente', function(Blueprint $table){
            $table->increments('id_proposta_proponente_assistente');
            $table->enum('regime_prestacao_servicos', ['tempo_parcial', 'tempo_parcial_60', 'tempo_integral', 'dedicacao_exclusiva']);
            $table->integer('percentagem_prestacao_servicos');
            $table->string('fundamentacao')->nullable();
            $table->string('periodo');
            $table->string('duracao');
            $table->enum('avaliacao_periodo_anterior', ['positiva', 'negativa'])->nullable();
            $table->integer('proposta_proponente_id')->unsigned();
            $table->foreign('proposta_proponente_id')->references('id_proposta_proponente')->on('proposta_proponente');
            //Signature???
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_proponente_monitor', function (Blueprint $table){
            $table->increments('id_proposta_proponente_monitor');
            $table->enum('regime_prestacao_servicos', ['tempo_parcial']);
            $table->integer('percentagem_prestacao_servicos');
            $table->string('periodo');
            $table->string('duracao');
            $table->integer('proposta_proponente_id')->unsigned();
            $table->foreign('proposta_proponente_id')->references('id_proposta_proponente')->on('proposta_proponente');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ucs_proposta_proponente', function(Blueprint $table){
            $table->increments('id_ucs_proposta_proponente');
            $table->string('codigo_uc');
            $table->enum('regime', ['Diurno', 'Pos-Laboral']);
            $table->enum('tipo', ['Semestral', 'Anual']);
            $table->integer('horas')->unsigned();
            $table->integer('horas_semestrais')->unsigned();
            $table->integer('departamento_id')->unsigned()->nullable(); //! Para já
            $table->foreign('departamento_id')->references('id')->on('departamento');
            $table->integer('proposta_proponente_id')->unsigned();
            $table->foreign('proposta_proponente_id')->references('id_proposta_proponente')->on('proposta_proponente');
            $table->string("turno");
        });

        Schema::create('proposta_diretor_uo', function(Blueprint $table){
            $table->increments('id_proposta_diretor_uo');
            $table->boolean('reconhecimento')->default(false);
            $table->enum('parecer', ['Favoravel', 'Desfavoravel']);
            $table->integer('diretor_uo_id')->unsigned();
            $table->foreign('diretor_uo_id')->references('id')->on('users');
            $table->dateTime('data_assinatura');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_ctc', function(Blueprint $table){
            $table->increments('id_proposta_ctc');
            $table->integer('votos_a_favor')->default(0);
            $table->integer('votos_contra')->default(0);
            $table->integer('votos_brancos')->default(0);
            $table->integer('votos_nulos')->default(0);
            $table->enum('aprovacao', ['Aprovado', 'Nao Aprovado']);
            $table->integer('ctc_id')->unsigned();
            $table->foreign('ctc_id')->references('id')->on('users');
            $table->dateTime('data_assinatura');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_secretariado_direcao', function(Blueprint $table){
            $table->increments('id_proposta_secretariado_direcao');
            $table->string('convite');
            $table->integer('secretariado_direcao_id')->unsigned();
            $table->foreign('secretariado_direcao_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta_recursos_humanos', function (Blueprint $table){
            $table->increments('id_proposta_recursos_humanos');
            $table->decimal('remuneracao', 6, 2);
            $table->string('escalao');
            $table->string('indice');
            $table->enum('verificacao_outras_uo', ['sim', 'nao']);
            $table->string('nome_uo')->nullable();
            $table->integer('tempo_parcial_uo')->nullable()->unsigned();
            $table->string('periodo_uo')->nullable();
            $table->integer('numero_funcionario')->unsigned();
            $table->enum('inscricao', ['seguranca_social', 'CGA']);
            $table->boolean('contratacao_comunicada')->default(false);
            $table->datetime('despacho_presidente_ipl');
            $table->boolean('contrato_redigido')->default(false);
            $table->boolean('contrato_anexo')->default(false);
            $table->boolean('cessacao_social')->default(false);
            $table->integer('NISS_ou_numero_CGA')->unsigned();
            $table->datetime('data_nascimento');
            $table->integer('numero_CC')->unsigned();
            $table->string('email_recursos_humanos')->unique();
            $table->string('dados_GIAF_carregados_por');
            $table->datetime('data_carregamento_dados_GIAF');
            $table->integer('recursos_humanos_id')->unsigned();
            $table->foreign('recursos_humanos_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('proposta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposta_proponente_id')->unsigned()->nullable();
            $table->foreign('proposta_proponente_id')->references('id_proposta_proponente')->on('proposta_proponente');
            $table->integer('proposta_diretor_uo_id')->unsigned()->nullable();
            $table->foreign('proposta_diretor_uo_id')->references('id_proposta_diretor_uo')->on('proposta_diretor_uo');
            $table->integer('proposta_ctc_id')->unsigned()->nullable();
            $table->foreign('proposta_ctc_id')->references('id_proposta_ctc')->on('proposta_ctc');
            $table->integer('proposta_secretariado_direcao_id')->unsigned()->nullable();
            $table->foreign('proposta_secretariado_direcao_id')->references('id_proposta_secretariado_direcao')->on('proposta_secretariado_direcao');
            $table->boolean('docente_inseriu_ficheiros')->default(false);
            $table->integer('proposta_recursos_humanos_id')->unsigned()->nullable();
            $table->foreign('proposta_recursos_humanos_id')->references('id_proposta_recursos_humanos')->on('proposta_recursos_humanos');
            $table->enum('status', ['pendente', 'recusada', 'finalizada']);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('ficheiro', function (Blueprint $table) {
            $table->increments('id');
            //$table->enum('type', ['pdf', 'png', 'jpeg']);
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->integer('proposta_id')->unsigned();
            $table->foreign('proposta_id')->references('id')->on('proposta');
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
