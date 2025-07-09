<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('senha');
            $table->string('tipo');
            $table->softDeletes();
        });

        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('nome_empresa');
            $table->string('cnpj');
            $table->string('telefone');
            // $table->softDeletes();
        });

        Schema::create('categorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nome');
        });

        Schema::create('prioridades', function (Blueprint $table) {
            $table->id('id_prioridade');
            $table->string('nome');
            $table->string('cor');
        });

        Schema::create('chamados', function (Blueprint $table) {
            $table->id('id_chamado');
            $table->string('titulo');
            $table->text('descricao');
            $table->dateTime('data_abertura');
            $table->dateTime('data_encerramento')->nullable();
            $table->dateTime('prazo_resolucao')->nullable();
            $table->string('status');
            $table->foreignId('id_usuario_solicitante')->constrained('usuarios', 'id_usuario');
            $table->foreignId('id_usuario_responsavel')->nullable()->constrained('usuarios', 'id_usuario');
            $table->foreignId('id_cliente')->constrained('clientes', 'id_cliente');
            $table->foreignId('id_categoria')->nullable()->constrained('categorias', 'id_categoria');
            $table->foreignId('id_prioridade')->nullable()->constrained('prioridades', 'id_prioridade');
            $table->softDeletes();
        });

        Schema::create('acompanhamentos', function (Blueprint $table) {
            $table->id('id_acompanhamento');
            $table->foreignId('id_chamado')->constrained('chamados', 'id_chamado');
            $table->text('texto');
            $table->dateTime('data_hora');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->softDeletes();
        });

        Schema::create('historico_status', function (Blueprint $table) {
            $table->id('id_historico');
            $table->foreignId('id_chamado')->constrained('chamados', 'id_chamado');
            $table->string('status');
            $table->dateTime('data');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
        });

        Schema::create('anexos', function (Blueprint $table) {
            $table->id('id_anexo');
            $table->string('nome_arquivo');
            $table->string('caminho');
            $table->string('tipo');
            $table->foreignId('id_acompanhamento')->nullable()->constrained('acompanhamentos', 'id_acompanhamento');
            $table->foreignId('id_chamado')->nullable()->constrained('chamados', 'id_chamado');
            $table->softDeletes();
        });

        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id('id_avaliacao');
            $table->foreignId('id_chamado')->constrained('chamados', 'id_chamado');
            $table->integer('nota');
            $table->text('comentario')->nullable();
            $table->dateTime('data');
        });

        Schema::create('log_usuarios', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->string('acao');
            $table->dateTime('data_hora');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_usuarios');
        Schema::dropIfExists('avaliacoes');
        Schema::dropIfExists('anexos');
        Schema::dropIfExists('historico_status');
        Schema::dropIfExists('acompanhamentos');
        Schema::dropIfExists('chamados');
        Schema::dropIfExists('prioridades');
        Schema::dropIfExists('categorias');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('usuarios');
    }
};
