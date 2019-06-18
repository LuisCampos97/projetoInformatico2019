<template>
  <div>
    <h2 class="pb-4">Ficheiros a inserir</h2>
    <h4 class="pb-4"> Por favor, insira os seguintes ficheiros para dar continuidade à proposta
        de contratação/renovação/alteração
    </h4>
    <b-form-group label="NIF">
        <b-form-file
          v-model="fileNIF"
          :state="Boolean(fileNIF)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <b-form-group label="N.º de CGA/SS">
        <b-form-file
          v-model="filenumeroCGA"
          :state="Boolean(filenumeroCGA)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <b-form-group label="Cópia do IBAN/NIB">
        <b-form-file
          v-model="fileCopiaCC"
          :state="Boolean(fileCopiaCC)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    
    <b-form-group label="Cópia do CC/BI">
        <b-form-file
          v-model="fileCopiaIBAN"
          :state="Boolean(fileCopiaIBAN)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <b-form-group label="Certificado de Registo Criminal">
        <b-form-file
          v-model="fileRegistoCriminal"
          :state="Boolean(fileRegistoCriminal)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <b-form-group label="Declaração de Robustez Física">
        <b-form-file
          v-model="fileRobustezFisica"
          :state="Boolean(fileRobustezFisica)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <b-form-group label="Cópia do Boletim de Vacinas">
        <b-form-file
          v-model="fileCopiaBoletimVacinas"
          :state="Boolean(fileCopiaBoletimVacinas)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <b-form-group label="Ficha de Identificação">
        <b-form-file
          v-model="fichaIdentificacao"
          :state="Boolean(fichaIdentificacao)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <b-form-group label="Declaração Artº 99 do IRS">
        <b-form-file
          v-model="fileDeclaracaoIRS"
          :state="Boolean(fileDeclaracaoIRS)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <b-form-group label="Declaração Comunic.Direitos/Renúncia ADSE">
        <b-form-file
          v-model="fileDeclaracaoRenunciaADSE"
          :state="Boolean(fileDeclaracaoRenunciaADSE)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <b-form-group label="Resposta à consulta das outras Escolas">
        <b-form-file
          v-model="fileRespostaOutrasEscolas"
          :state="Boolean(fileRespostaOutrasEscolas)"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
        ></b-form-file>
    </b-form-group>

    <button
        class="btn btn-success mt-3 font-weight-bold">
        Submeter Ficheiros
      </button>

  </div>
</template>
<script>
export default {
  data() {
    return {
        fileNIF:"",
        filenumeroCGA:"",
        fileCopiaCC:"",
        fileCopiaIBAN:"",
        fileRegistoCriminal:"",
        fileRobustezFisica:"",
        fileCopiaBoletimVacinas:"",
        fichaIdentificacao:"",
        fileDeclaracaoIRS:"",
        fileDeclaracaoRenunciaADSE:"",
        fileRespostaOutrasEscolas:"",
    };
  }
};
</script>