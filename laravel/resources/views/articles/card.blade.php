<div class="row">
                <div class="col-md mb-4">
                    <div class="card article-card">
                        <div class="card-body d-flex flex-row row">
                            <div class="col-2">
                              @if(isset($article->user->uploadimages))
                              <a href="{{ route('users.show', ['id' => $article->user->id]) }}" class="text-dark">
	                              <img src="{{ Storage::url($article->user->uploadimages->file_path) }}" style="width:100%;" alt="写真"/>
	                            </a>
                              @else
                              <a href="{{ route('users.show', ['id' => $article->user->id]) }}" class="text-dark">
                                <i class="fas fa-user-circle fa-3x mr-1"></i>
                              </a>
                              @endif
                            </div>
                            <div style="" class="col-8">
                                <h5 class="font-weight-bold">
                      	          <a href="{{ route('users.show', ['id' => $article->user->id]) }}" class="text-dark">
                      	            名前: {{ $article->user->name }}
                      	          </a>
                    	         </h5>
                    	         <h6 class="font-weight-lighter">投稿日時: {{ $article->created_at->format('Y/m/d H:i') }}</h6>
                                <a class="text-dark" href="{{ route('articles.show', ['id' => $article->id]) }}"><h4>コメント: {{ $article->body }}</h4></a>
                    	  　  </div>
                	  　      <!-- dropdown -->
                      	  　@if ($article->user_id == Auth::id())
                              <div class="col-1 card-text">
                                <div class="dropdown text-center">
                                  <a class="in-link p-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-lg"></i>
                                  </a>
                                  <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('articles.edit', ['id' => $article->id]) }}">
                                      <i class="fas fa-pen mr-1"></i>投稿を編集する
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    {!! Form::model($article, ['route' => ['articles.destroy', $article->id], 'method' => 'delete']) !!}
                                    {!! Form::submit('投稿を削除する', ['class' => 'dropdown-item text-danger ']) !!}
                                    {!! Form::close() !!}
                                  </div>
                                </div>
                              </div>
                              <!-- dropdown -->
                            @endif
                	      </div>
                	   <div class="card-body pt-0 pb-2 pl-3">
                        <div class="card-text">
                          <article-like
                            v-bind:initial-is-liked-by='@json($article->isLikedBy(Auth::user()))'
                            :initial-count-likes='@json($article->count_likes)'
                            :authorized='@json(Auth::check())'
                            endpoint="{{ route('articles.like', ['article' => $article]) }}"
                          >
                          </article-like>
                        </div>
                      </div>
            	    </div>
                </div>
            </div>