<?php

    //CRUD
    class TarefaService{
        private $conexao;
        private $tarefa;

        public function __construct(Conexao $conexao, Tarefa $tarefa){//tipagem da classe
            $this->conexao = $conexao->conectar();
            $this->tarefa = $tarefa;
        }
        public function inserir(){//create
            $query = '
                insert into 
                    tb_tarefas(tarefa)values(?)
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('tarefa'));
            $stmt->execute();
        }

        public function recuperar(){//read
            $query = '
                select 
                    tb_tarefas.id, tb_status.status, tb_tarefas.tarefa 
                from 
                    tb_tarefas
                    left join tb_status on (tb_tarefas.id_status = tb_status.id)
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function atualizar(){//update
            $query = 'update 
                        tb_tarefas set tarefa = ? 
                    where 
                        id = ?
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('tarefa'));
            $stmt->bindValue(2, $this->tarefa->__get('id'));
            return $stmt->execute();

        }

        public function remover(){//delete
            $query = ' delete from 
                            tb_tarefas 
                        where 
                            id = ?
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('id'));
            return $stmt->execute();
            
        }

        public function marcarRealizada(){//update
            $query = 'update 
                        tb_tarefas set id_status = ? 
                    where 
                        id = ?
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('id_status'));
            $stmt->bindValue(2, $this->tarefa->__get('id'));
            return $stmt->execute();

        }

        public function recuperar_pendente(){//read
            $query = '
                select 
                    tb_tarefas.id, tb_status.status, tb_tarefas.tarefa 
                from 
                    tb_tarefas
                    left join tb_status on (tb_tarefas.id_status = tb_status.id)
                where
                    tb_tarefas.id_status = ?
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('id_status'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }




?>