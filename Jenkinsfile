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
        sh 'echo $BUILD_NUMBER'
      }
    }

    stage('Build & tag container') {
      steps {
        container('docker') {
            sh 'docker build -t simonloudev/celobat:${BUILD_NUMBER} .'
            sh 'docker tag simonloudev/celobat:${BUILD_NUMBER} simonloudev/celobat:latest'
            sh 'docker push simonloudev/celobat:${BUILD_NUMBER}'
            sh 'docker push simonloudev/celobat:latest'
        }
      }
    }

  }
}
