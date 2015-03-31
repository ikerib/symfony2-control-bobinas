set :application, "Control Bobinas"
set :domain,      "192.168.1.1"
set :user,        "root"
set :deploy_to,   "/var/www/validacion"
set :app_path,    "app"

set :use_composer, true
set :scm,         :git
set :scm_verbose, true
set :branch,      "master"
set :repository,  "file:///Users/ikerib/www/controlbobinas"
#set :deploy_via,  :copy
set :deploy_via, :rsync_with_remote_cache

# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server
#role :db,         domain, :primary => true       # This is where Rails migrations will run

set :writable_dirs,       ["app/cache", "app/logs"]
set :webserver_user,      "www-data"
set :permission_method,   :acl
set :use_set_permissions, true

set  :use_sudo,         false
set  :keep_releases,    5
set  :shared_files,     ["app/config/parameters.yml"]
set  :shared_children,  [app_path + "/logs",web_path + "/uploads", web_path + "/images",web_path + "/video",web_path + "/media", "vendor"]

set :writable_dirs, [app_path + "/cache", app_path + "/logs", web_path + "/uploads"]
set :webserver_user,      "www-data"
set :permission_method,   :acl
set :use_set_permissions, true

set  :php_bin,          "/usr/bin/php"
set  :update_vendors,   false

set  :dump_assetic_assets, false
# after "deploy", "deploy:cleanup"
default_run_options[:pty] = true


# perform tasks after deploying
after "deploy" do
  # clear the cache
  run "cd /var/www/superlinea/current && php app/console cache:clear --env=prod --no-debug"

  # dump assets (if using assetic)
  run "cd /var/www/superlinea/current && php app/console assetic:dump --env=prod --no-debug"
end

# Be more verbose by uncommenting the following line
#logger.level = Logger::MAX_LEVEL