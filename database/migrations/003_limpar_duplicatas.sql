-- Remover duplicatas mantendo apenas o registro mais recente
DELETE c1 FROM clientes c1
INNER JOIN clientes c2
WHERE c1.id < c2.id 
AND c1.nome = c2.nome 
AND c1.telefone = c2.telefone;
