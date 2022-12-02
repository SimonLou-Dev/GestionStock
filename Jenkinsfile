pipeline {
  agent any
  stages {
    stage('Cleaning') {
      steps {
        cleanWs()
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
        script {
          def image = docker.build("simonloudev/celobat:${env.BUILD_NUMBER}")
          docker.withRegistry('https://registry.hub.docker.com', 'docker-hub-credentials') {
            app.push("${env.BUILD_NUMBER}")
            app.push("latest")
          }
        }

      }
    }

  }
}