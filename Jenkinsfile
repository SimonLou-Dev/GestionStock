pipeline {
  agent {
    label 'jenkins-slave'
  }
  stages {
    stage('Verification') {
      steps {
        checkout scm
        validateDeclarativePipeline 'Jenkinsfile'
        sh 'php -v'
        sh 'php -i'
      }
    }

    stage('Composer & yarn Install') {
      steps {
        sh 'composer install'
        sh 'yarn install'
        sh 'export BUILD_NUMBER=${BUILD_NUMBER}'
      }
    }

    stage('Testing environment setup') {
      steps {
        withCredentials(bindings: [file(credentialsId: 'env-gestion-stoque-test', variable: 'envfile')]) {
          writeFile(file: '.env', text: readFile(envfile))
        }

        sh 'php artisan key:generate'
        sh 'php artisan migrate:fresh --seed'
      }
    }

    stage('PHP Testing') {
      steps {
        sh 'php -d xdebug.mode=coverage ./vendor/bin/phpunit --coverage-clover ./reports/coverage.xml --log-junit ./reports/test.xml'
      }
    }

    stage('SonarScanner') {
      environment {
        scannerHome = 'scanner'
      }
      steps {
        withSonarQubeEnv(installationName: 'SonarServ', credentialsId: 'sonar-token') {
          sh '${scannerHome}/bin/sonar-scanner'
        }

      }
    }

    stage('Fresh Database') {
      steps {
        sh 'php artisan migrate:reset'
        sh 'rm .env'
      }
    }

    stage('Production environment setup') {
      steps {
        withCredentials(bindings: [file(credentialsId: 'env-gestion-stoque-prod', variable: 'envfile')]) {
          writeFile(file: '.env', text: readFile(envfile))
        }

        sh 'php artisan key:generate'
      }
    }

    stage('Build & tag container') {
      steps {
        container(name: 'docker') {
          sh 'ls && ls ./docker'
          script {
            docker.withRegistry('http://registry.hub.docker.com/', 'docker-hub-credentials') {
              def img = docker.build "simonloudev/celobat:latest"
              img.push("latest")
              img.push("${env.BUILD_NUMBER}")
            }
          }

        }

      }
    }

    stage('Deploy on Kubernetes') {
      steps {
        kubeconfig(serverUrl: 'http://38.242.193.116:6443', credentialsId: 'Secret text', caCertificate: 'Secret text') {
          sh 'kubectl rollout restart deployment/celobat'
        }

      }
    }

  }
}