<?php
namespace controllers;

use models\Comment;

class CommentController {
    private $commentModel;

    public function __construct(Comment $comment) {
        $this->commentModel = $comment;
    }

    public function create($post_id, $user_id, $content) {
        return $this->commentModel->create($post_id, $user_id, $content);
    }

    public function read($id) {
        return $this->commentModel->read($id);
    }

    public function update($id, $content) {
        return $this->commentModel->update($id, $content);
    }

    public function delete($id) {
        return $this->commentModel->delete($id);
    }

    public function getAllComments($post_id) {
        return $this->commentModel->getCommentsByPostId($post_id);
    }
}
