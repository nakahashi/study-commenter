class CommentsController < ApplicationController
  def index
    @comment = Comment.new
    @comments = Comment.all
  end

  def create
    Comment.create(content: comment_params[:content])
    redirect_to comments_url
  end

  def destroy
    Comment.destroy_all
    redirect_to comments_url
  end

  private

  def comment_params
    params.require(:comment).permit(:content)
  end
end
