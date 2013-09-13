import java.io.*;
import java.util.List;
import java.util.ArrayList;
import java.util.HashSet;

public class Knap1 {
    private static ArrayList<Integer> knapsack(int[] w, int[] v, int max) {
        ArrayList<ArrayList<ArrayList<Integer>>> t = new ArrayList<ArrayList<ArrayList<Integer>>>();
        t.add(new ArrayList<ArrayList<Integer>>());
        t.add(new ArrayList<ArrayList<Integer>>());
        HashSet<Integer> without = new HashSet<Integer>();
        HashSet<Integer> with = new HashSet<Integer>();
        int i,j;

        for (i=0; i<2; i++) {
            for (j=0; j<=max; j++)
                t.get(i).add(new ArrayList<Integer>());
        } // End t initialization

        for (i=1; i<=v.length; i++) {
            for (j=1; j<=max; j++) {
                without.clear();
                without.addAll(t.get((i-1)%2).get(j));
                with.clear();
                if ((j - w[i-1]) >= 0) {
                    with.addAll(t.get((i-1)%2).get(j-w[i-1]));
                    with.add(i-1);
                }
                if (value(without, v) > value(with, v))
                    t.get(i%2).set(j,new ArrayList<Integer>(without));
                else
                    t.get(i%2).set(j,new ArrayList<Integer>(with));
            }
        }

        return t.get(1).get(max);
    }

    private static int value(HashSet<Integer> s, int[] v) {
        int total = 0;
        for (Integer i : s)
            total += v[i];
        return total;
    }

    private static int arrayValue(ArrayList<Integer> s, int[] v) {
        int total = 0;
        for (Integer i : s)
            total += v[i];
        return total;
    }

    private static int weight(HashSet<Integer> s, int[] w) {
        int total = 0;
        for (Integer i : s)
            total += w[i];
        return total;
    }

    private static int arrayWeight(ArrayList<Integer> s, int[] w) {
        int total = 0;
        for (Integer i : s)
            total += w[i];
        return total;
    }

    public static void main(String[] args) {
        int n = 0;
        int w = 0;
        if (args.length == 2) {
            try {
                n = Integer.parseInt(args[0]);
                w = Integer.parseInt(args[1]);
            } catch (NumberFormatException e) {
                System.err.println("Arguments must be of type int.");
                System.exit(1);
            }
        } else {
            System.out.println("You need to enter to inputs: n, W.");
            System.exit(1);
        }

        BufferedReader reader = null;
        String strRead = "";
        int[] weights = new int[n];
        int[] values = new int[n];
        Package[] pkgs = new Package[n];
        try {
            reader = new BufferedReader(new FileReader("packages.txt"));
        } catch (FileNotFoundException e) {
            System.out.println("Error: " + e);
        }

        try {
            strRead = reader.readLine();
            int count = 0;
            while ((strRead = reader.readLine()) != null && count < n) {
                String splitArray[] = strRead.split(" ");
                String pkgName = splitArray[0];
                int pkgVotes = Integer.parseInt(splitArray[1]);
                int pkgSize = Integer.parseInt(splitArray[2]);
                pkgs[count] = new Package(pkgName,pkgSize,pkgVotes);
                weights[count] = pkgSize;
                values[count] = pkgVotes;
                count++;
            }
        } catch (IOException e) {
            System.out.println("Error: " + e);
        }

        // Knapsack Algorithm
        Long start = System.currentTimeMillis();
        ArrayList<Integer> result = knapsack(weights,values,w);
        Long end = System.currentTimeMillis();

        int count = 0;
        for (Integer i : result) {
            System.out.println("Name=" + pkgs[i].getName() + " " +
                              "Votes=" + pkgs[i].getVotes() + " " +
                              "Size=" + pkgs[i].getSize());
            count++;
            if (count == 20)
                break;
        }
        System.out.println("Total: " + arrayValue(result,values));
        System.out.println("Size: " + arrayWeight(result,weights));
        System.out.println("Length: " + result.size());
        System.out.println("Milliseconds: " + (end-start));
    }
}