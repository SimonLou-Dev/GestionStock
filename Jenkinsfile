pipeline {
  agent {label 'jenkins-slave'}
  stages {
    stage('Cleaning') {
      steps {
        sh "ls"
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
            script {
                docker.withRegistry('docker.io', 'docker-hub-credentials') {
                    def img = docker.build "simonloudev/celobat"
                    img.push("${env.BUILD_NUMBER}")
                    img.push("latest")
                }
            }
        }
      }
    }

  }
}
