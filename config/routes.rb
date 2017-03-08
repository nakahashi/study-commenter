Rails.application.routes.draw do
  get 'comments', to: 'comments#index'
  post 'comments', to: 'comments#create'
  delete 'comments', to: 'comments#destroy'

  root 'comments#index'
end
