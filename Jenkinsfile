pipeline {
  agent {label 'jenkins-slave'}
  stages {
    stage('Cleaning') {
      steps {
        checkout scm
      }
    }

    stage('Verification') {
      steps {
        validateDeclarativePipeline 'Jenkinsfile'
        sh 'php -v'
        sh 'php -i'
      }
    }


    stage('Composer & yarn Install') {
        steps {
            sh 'composer install'
            sh 'yarn install'
        }
    }

    stage('Write .env [prod]') {
      steps {
        withCredentials(bindings: [file(credentialsId: 'env-gestion-stoque-prod', variable: 'envfile')]) {
          writeFile(file: '.env', text: readFile(envfile))
        }

        sh 'php artisan key:generate'
      }
    }

    stage('Build & tag container') {
      steps {
        sh 'kaniko/executor --dockerfile=Dockerfile --context="pwd" --destination simonloudev/celobat:${env.BUILD_NUMBER} --destination simonloudev/celobat:latest'
      }
    }

  }
}
