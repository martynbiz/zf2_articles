<?php
namespace Article\Model;

use Zend\Db\TableGateway\TableGateway;

class ArticleTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getArticle($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
           throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveArticle(Article $article)
    {
        $data = array(
           'title'  => $article->title,
        );

        $id = (int) $article->id;
        if ($id == 0) {
           $this->tableGateway->insert($data);
        } else {
           if ($this->getArticle($id)) {
              $this->tableGateway->update($data, array('id' => $id));
           } else {
              throw new \Exception('Article id does not exist');
           }
        }
    }

    public function deleteArticle(Article $article)
    {
        $this->tableGateway->delete(array('id' => (int) $article->id));
    }
}
